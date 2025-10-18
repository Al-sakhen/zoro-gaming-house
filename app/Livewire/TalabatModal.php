<?php

namespace App\Livewire;

use App\Models\CafeteriaItem;
use App\Models\Order;
use App\Models\Session;
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

        foreach ($this->selectedItems as $itemId => $data) {
            if ($data['quantity'] > 0) {
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
            session()->flash('message', "Successfully added {$savedOrders} items to the order!");
            $this->resetSelectedItems();
            $this->dispatch('closeModal');
        } else {
            session()->flash('error', 'Please select at least one item!');
        }
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
        return view('livewire.talabat-modal');
    }
}
