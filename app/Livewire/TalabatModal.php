<?php

namespace App\Livewire;

use App\Models\CafeteriaItem;
use App\Models\Order;
use App\Models\Session;
use App\Services\StockService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class TalabatModal extends Component
{
    public $session;
    public $sessionId;
    public $cafeteriaItems = [];
    public $selectedItems = []; // Array to store selected items with quantities
    public $totalCafeteriaPrice = 0;
    public $totalGamingPrice = 0;
    public $grandTotal = 0;
    public $barcodeInput = '';


    public function mount()
    {
        $this->loadCafeteriaItems();
    }


    #[On('setSession')]
    public function setSession(Session $session)
    {
        $this->sessionId = $session->id;
        $this->session = $session;
        $this->calculateTotals();
    }

    public function loadCafeteriaItems()
    {
        $this->cafeteriaItems = CafeteriaItem::active()->get();
        // Initialize selected items array
        foreach ($this->cafeteriaItems as $item) {
            $this->selectedItems[$item->id] = [
                'quantity' => 0,
                'price' => $item->price_per_item,
                'total' => 0
            ];
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

        DB::transaction(function () use (&$savedOrders, &$warnings) {
            foreach ($this->selectedItems as $itemId => $data) {
                if ($data['quantity'] <= 0) {
                    continue;
                }

                $stockResult = app(StockService::class)->applyReservationDelta(
                    (int) $itemId,
                    (int) $data['quantity'],
                    (int) $this->session->id,
                    'talabat_modal_save',
                    'Session order add from modal'
                );

                $item = $stockResult['item'];
                if ($stockResult['tracked'] && (int) $data['quantity'] > (int) $stockResult['before']) {
                    $warnings[] = "{$item->name} requested {$data['quantity']} while stock is {$stockResult['before']}";
                }

                Order::create([
                    'session_id' => $this->session->id,
                    'cafeteria_item_id' => $itemId,
                    'units_count' => (int) $data['quantity'],
                    'price_per_unit' => $data['price'],
                    'total_price' => $data['total']
                ]);
                $savedOrders++;
            }
        });

        if ($savedOrders > 0) {
            session()->flash('message', "Successfully added {$savedOrders} items to the order!");
            if (!empty($warnings)) {
                session()->flash('warning', 'Stock warning: ' . implode(' | ', $warnings));
            }
            $this->resetSelectedItems();
            $this->dispatch('talabatOrderSaved');
            $this->dispatch('close-talabat-modal');
        } else {
            session()->flash('error', 'Please select at least one item!');
        }
    }

    public function resetSelectedItems()
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

        $item = collect($this->cafeteriaItems)->first(function ($cafeteriaItem) use ($barcode) {
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
        $item = collect($this->cafeteriaItems)->firstWhere('id', $itemId);
        if (!$item || $item->quantity === null) {
            return;
        }

        $requested = $this->selectedItems[$itemId]['quantity'];
        if ($requested > $item->quantity) {
            session()->flash('warning', "Stock warning: {$item->name} requested {$requested} while stock is {$item->quantity}.");
        }
    }

    public function render()
    {
        return view('livewire.talabat-modal');
    }
}
