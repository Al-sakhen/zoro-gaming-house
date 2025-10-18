<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Session;
use Livewire\Component;
use Livewire\Attributes\Validate;

class OrderDialog extends Component
{
    public Session $session;
    
    #[Validate('numeric|min:0')]
    public $drinks_price = 0.00;

    #[Validate('numeric|min:0')]
    public $shisha_price = 0.00;

    #[Validate('numeric|min:0')]
    public $coffee_price = 0.00;

    #[Validate('numeric|min:0')]
    public $discount_amount = 0.00;

    public $gaming_price = 0;
    public $total_amount = 0;

    public function mount(Session $session)
    {
        $this->session = $session;
        $this->gaming_price = $session->calculateGamingPrice();
        $this->calculateTotal();
    }

    public function updatedDrinksPrice()
    {
        $this->calculateTotal();
    }

    public function updatedShishaPrice()
    {
        $this->calculateTotal();
    }

    public function updatedCoffeePrice()
    {
        $this->calculateTotal();
    }

    public function updatedDiscountAmount()
    {
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        // Ensure numeric values
        $gaming = floatval($this->gaming_price);
        $drinks = floatval($this->drinks_price ?: 0);
        $shisha = floatval($this->shisha_price ?: 0);
        $coffee = floatval($this->coffee_price ?: 0);
        $discount = floatval($this->discount_amount ?: 0);
        
        $subtotal = $gaming + $drinks + $shisha + $coffee;
        $this->total_amount = max(0, $subtotal - $discount);
    }

    public function createOrder()
    {
        $this->validate();

        try {
            $order = Order::create([
                'session_id' => $this->session->id,
                'gaming_price' => floatval($this->gaming_price),
                'drinks_price' => floatval($this->drinks_price ?: 0),
                'shisha_price' => floatval($this->shisha_price ?: 0),
                'coffee_price' => floatval($this->coffee_price ?: 0),
                'discount_amount' => floatval($this->discount_amount ?: 0),
                'total_amount' => floatval($this->total_amount),
            ]);

            session()->flash('message', 'Order #' . $order->id . ' created successfully!');
            
            $this->dispatch('sessionStopped');
            $this->dispatch('closeDialog');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error creating order: ' . $e->getMessage());
        }
    }

    public function getDurationDisplay()
    {
        $duration = $this->session->getDurationInMinutes();
        $hours = intval($duration / 60);
        $minutes = $duration % 60;
        
        return sprintf('%d hours %d minutes', $hours, $minutes);
    }

    public function render()
    {
        return view('livewire.order-dialog');
    }
}
