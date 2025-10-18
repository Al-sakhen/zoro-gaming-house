<?php

namespace App\Livewire\Dashboard\Cafeteria;

use App\Models\CafeteriaItem;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public $cafeteriaItemId;
    public $name = '';
    public $price_per_item = '';
    public $status = 1;

    protected $listeners = ['setEditCafeteriaItem'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'price_per_item' => 'required|numeric|min:0.01',
        'status' => 'required|boolean',
    ];

    #[On('setEditCafeteriaItem')]
    public function setEditCafeteriaItem(CafeteriaItem $item)
    {
        $this->cafeteriaItemId = $item->id;
        $this->name = $item->name;
        $this->price_per_item = $item->price_per_item;
        $this->status = $item->status;
    }

    public function update()
    {
        $this->validate();

        $cafeteriaItem = CafeteriaItem::findOrFail($this->cafeteriaItemId);

        $cafeteriaItem->update([
            'name' => $this->name,
            'price_per_item' => $this->price_per_item,
            'status' => $this->status,
        ]);

        $this->dispatch('success', 'Cafeteria item updated successfully!');
        $this->dispatch('refreshTable');
        $this->dispatch('closeEditModal');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.dashboard.cafeteria.edit');
    }
}
