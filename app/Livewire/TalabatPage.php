<?php

namespace App\Livewire;

use App\Models\CafeteriaItem;
use App\Models\Order;
use App\Models\Session;
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
            $this->cafeteriaItems = $this->allCafeteriaItems->filter(function ($item) {
                return stripos($item->name, $this->searchFilter) !== false;
            })->values(); // Reset array keys
        }
    }

    public function updatedSearchFilter()
    {
        $this->filterItems();
    }

    public function loadExistingOrders()
    {
        // Load existing orders from gaming_orders table for this session
        $existingOrders = Order::where('session_id', $this->session->id)->get();
        
        foreach ($existingOrders as $order) {
            if (isset($this->selectedItems[$order->cafeteria_item_id])) {
                $this->selectedItems[$order->cafeteria_item_id]['quantity'] = $order->units_count;
                $this->selectedItems[$order->cafeteria_item_id]['total'] = $order->total_price;
            }
        }
    }

    public function incrementItem($itemId)
    {
        $this->selectedItems[$itemId]['quantity']++;
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

        // Clear existing temporary orders for this session
        Order::where('session_id', $this->session->id)->delete();

        $savedOrders = 0;
        
        foreach ($this->selectedItems as $itemId => $data) {
            if ($data['quantity'] > 0) {
                // Save to gaming_orders table as temporary orders
                Order::create([
                    'session_id' => $this->session->id,
                    'cafeteria_item_id' => $itemId,
                    'units_count' => $data['quantity'],
                    'price_per_unit' => $data['price'],
                    'total_price' => $data['total']
                ]);
                $savedOrders++;
            }
        }

        if ($savedOrders > 0) {
            session()->flash('message', "Successfully updated {$savedOrders} items in the order! (Temporary - will be saved when session ends)");
            session()->flash('closeWindow', true);
        } else {
            // If no items selected, clear all orders
            session()->flash('message', "Order cleared successfully!");
            session()->flash('closeWindow', true);
        }
    }

    public function goBack()
    {
        session()->flash('closeWindow', true);
    }

    private function resetSelectedItems()
    {
        foreach ($this->selectedItems as $itemId => $data) {
            $this->selectedItems[$itemId]['quantity'] = 0;
            $this->selectedItems[$itemId]['total'] = 0;
        }
        $this->calculateTotals();
    }

    public function render()
    {
        return view('livewire.talabat-page');
    }
}
