<?php

namespace App\Livewire\Dashboard\Cafeteria;

use App\Models\CafeteriaItem;
use Livewire\Component;

class Create extends Component
{
    public $name = '';
    public $price_per_item = '';
    public $status = 1;

    protected $rules = [
        'name' => 'required|string|max:255',
        'price_per_item' => 'required|numeric|min:0.01',
        'status' => 'required|boolean',
    ];

    public function save()
    {
        $this->validate();

        CafeteriaItem::create([
            'name' => $this->name,
            'price_per_item' => $this->price_per_item,
            'status' => $this->status,
        ]);

        $this->dispatch('success', 'Cafeteria item created successfully!');
        $this->dispatch('refreshTable');
        $this->dispatch('closeCreateModal');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.dashboard.cafeteria.create');
    }
}
