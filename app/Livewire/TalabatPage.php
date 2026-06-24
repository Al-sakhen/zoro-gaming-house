<?php

namespace App\Livewire;

use App\Models\CafeteriaItem;
use App\Models\Order;
use App\Models\Session;
use App\Services\StockService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TalabatPage extends Component
{
    public $session;
    public $cafeteriaItems = [];
    public $allCafeteriaItems = []; // Store all items for filtering
    public $selectedItems = []; // Array to store selected items with quantities
    public $totalCafeteriaPrice = 0;
    public $totalGamingPrice = 0;
    public $grandTotal = 0;
    public $searchFilter = ''; // Search filter property
    public $barcodeInput = '';

    public function mount(Session $session)
    {
        $this->session = $session;
        $this->loadCafeteriaItems();
        $this->loadExistingOrders();
        $this->calculateTotals();
    }

    public function loadCafeteriaItems()
    {
        $this->allCafeteriaItems = CafeteriaItem::active()->get();
        $this->filterItems();
        
        // Initialize selected items array for all items
        foreach ($this->allCafeteriaItems as $item) {
            $this->selectedItems[$item->id] = [
                'quantity' => 0,
                'price' => $item->price_per_item,
                'total' => 0
            ];
        }
    }

    public function filterItems()
    {
        if (empty($this->searchFilter)) {
            $this->cafeteriaItems = $this->allCafeteriaItems;
        } else {
            $this->cafeteriaItems = collect($this->allCafeteriaItems)->filter(function ($item) {
                $needle = strtolower($this->searchFilter);
                return str_contains(strtolower($item->name), $needle)
                    || str_contains(strtolower((string) ($item->barcode ?? '')), $needle);
            })->values(); // Reset array keys
        }
    }

    public function updatedSearchFilter()
    {
        $this->filterItems();
    }

    public function loadExistingOrders()
    {
        $quantitiesByItem = Order::query()
            ->where('session_id', $this->session->id)
            ->selectRaw('cafeteria_item_id, SUM(units_count) as total_units')
            ->groupBy('cafeteria_item_id')
            ->pluck('total_units', 'cafeteria_item_id');

        foreach ($quantitiesByItem as $itemId => $units) {
            if (isset($this->selectedItems[$itemId])) {
                $quantity = (int) $units;
                $this->selectedItems[$itemId]['quantity'] = $quantity;
                $this->selectedItems[$itemId]['total'] = $quantity * $this->selectedItems[$itemId]['price'];
            }
        }
    }

    public function incrementItem($itemId)
    {
        $this->selectedItems[$itemId]['quantity']++;
        $this->warnIfStockExceeded($itemId);
        $this->updateItemTotal($itemId);
        $this->calculateTotals();
    }

    public function decrementItem($itemId)
    {
        if ($this->selectedItems[$itemId]['quantity'] > 0) {
            $this->selectedItems[$itemId]['quantity']--;
            $this->updateItemTotal($itemId);
            $this->calculateTotals();
        }
    }

    private function updateItemTotal($itemId)
    {
        $quantity = $this->selectedItems[$itemId]['quantity'];
        $price = $this->selectedItems[$itemId]['price'];
        $this->selectedItems[$itemId]['total'] = $quantity * $price;
    }

    private function calculateTotals()
    {
        $this->totalCafeteriaPrice = array_sum(array_column($this->selectedItems, 'total'));
        
        if ($this->session) {
            $this->totalGamingPrice = $this->session->calculateGamingPrice();
            $this->grandTotal = $this->totalGamingPrice + $this->totalCafeteriaPrice;
        }
    }

    public function saveOrders()
    {
        if (!$this->session) {
            session()->flash('error', 'Session not found!');
            return;
        }

        $savedOrders = 0;
        $warnings = [];
        $stockService = app(StockService::class);

        DB::transaction(function () use (&$savedOrders, &$warnings, $stockService) {
            $existingQuantitiesByItem = Order::query()
                ->where('session_id', $this->session->id)
                ->selectRaw('cafeteria_item_id, SUM(units_count) as total_units')
                ->groupBy('cafeteria_item_id')
                ->pluck('total_units', 'cafeteria_item_id');

            foreach ($this->selectedItems as $itemId => $data) {
                $newQuantity = (int) $data['quantity'];
                $oldQuantity = (int) ($existingQuantitiesByItem[$itemId] ?? 0);
                $delta = $newQuantity - $oldQuantity;

                if ($delta === 0) {
                    continue;
                }

                $stockResult = $stockService->applyReservationDelta(
                    (int) $itemId,
                    $delta,
                    (int) $this->session->id,
                    'talabat_page_save',
                    'Session order update'
                );

                $item = $stockResult['item'];
                if ($stockResult['tracked'] && $delta > 0 && $delta > (int) $stockResult['before']) {
                    $warnings[] = "{$item->name} requested {$newQuantity} while available stock is {$stockResult['before']} (excluding this session reservation).";
                }
            }

            // Recreate temporary orders with the latest quantities.
            Order::query()->where('session_id', $this->session->id)->delete();

            foreach ($this->selectedItems as $itemId => $data) {
                if ($data['quantity'] > 0) {
                    Order::create([
                        'session_id' => $this->session->id,
                        'cafeteria_item_id' => $itemId,
                        'units_count' => (int) $data['quantity'],
                        'price_per_unit' => $data['price'],
                        'total_price' => $data['total']
                    ]);
                    $savedOrders++;
                }
            }
        });

        if ($savedOrders > 0) {
            session()->flash('message', "Successfully updated {$savedOrders} items in the order! (Temporary - will be saved when session ends)");
            if (!empty($warnings)) {
                session()->flash('warning', 'Stock warning: ' . implode(' | ', $warnings));
            }
            $this->dispatch('closeTalabatWindow');
        } else {
            // If no items selected, clear all orders
            session()->flash('message', "Order cleared successfully!");
            $this->dispatch('closeTalabatWindow');
        }
    }

    public function goBack()
    {
        $this->dispatch('closeTalabatWindow');
    }

    private function resetSelectedItems()
    {
        foreach ($this->selectedItems as $itemId => $data) {
            $this->selectedItems[$itemId]['quantity'] = 0;
            $this->selectedItems[$itemId]['total'] = 0;
        }
        $this->calculateTotals();
    }

    public function addByBarcode(): void
    {
        $barcode = trim((string) $this->barcodeInput);

        if ($barcode === '') {
            session()->flash('error', 'Please scan or enter a barcode first.');
            return;
        }

        $item = collect($this->allCafeteriaItems)->first(function ($cafeteriaItem) use ($barcode) {
            return (string) ($cafeteriaItem->barcode ?? '') === $barcode;
        });

        if (!$item) {
            session()->flash('error', "No active item found for barcode: {$barcode}");
            $this->barcodeInput = '';
            return;
        }

        $this->incrementItem($item->id);
        $this->barcodeInput = '';
        session()->flash('message', "Added {$item->name} by barcode.");
    }

    private function warnIfStockExceeded($itemId): void
    {
        $item = collect($this->allCafeteriaItems)->firstWhere('id', $itemId);
        if (!$item || $item->quantity === null) {
            return;
        }

        $requested = $this->selectedItems[$itemId]['quantity'];
        $alreadyReservedForThisSession = (int) Order::query()
            ->where('session_id', $this->session->id)
            ->where('cafeteria_item_id', $itemId)
            ->sum('units_count');
        $effectiveAvailable = (int) $item->quantity + $alreadyReservedForThisSession;

        if ($requested > $effectiveAvailable) {
            session()->flash('warning', "Stock warning: {$item->name} requested {$requested} while effective available stock is {$effectiveAvailable}.");
        }
    }

    public function render()
    {
        return view('livewire.talabat-page');
    }
}
