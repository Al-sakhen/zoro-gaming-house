<?php

namespace App\Livewire;

use App\Models\CafeteriaItem;
use Livewire\Component;
use Livewire\WithPagination;

class CafeteriaManager extends Component
{
    use WithPagination;

    public $name = '';
    public $price_per_item = '';
    public $status = 1;
    public $editingId = null;
    public $showForm = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'price_per_item' => 'required|numeric|min:0.01',
        'status' => 'required|boolean',
    ];

    public function addNew()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit($id)
    {
        $item = CafeteriaItem::findOrFail($id);
        $this->editingId = $id;
        $this->name = $item->name;
        $this->price_per_item = $item->price_per_item;
        $this->status = $item->status;
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            $item = CafeteriaItem::findOrFail($this->editingId);
            $item->update([
                'name' => $this->name,
                'price_per_item' => $this->price_per_item,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Cafeteria item updated successfully!');
        } else {
            CafeteriaItem::create([
                'name' => $this->name,
                'price_per_item' => $this->price_per_item,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Cafeteria item created successfully!');
        }

        $this->resetForm();
    }

    public function delete($id)
    {
        $item = CafeteriaItem::findOrFail($id);
        $item->delete();
        session()->flash('message', 'Cafeteria item deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $item = CafeteriaItem::findOrFail($id);
        $item->update(['status' => !$item->status]);
        session()->flash('message', 'Cafeteria item status updated successfully!');
    }

    public function resetForm()
    {
        $this->reset(['name', 'price_per_item', 'status', 'editingId', 'showForm']);
        $this->status = 1;
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.cafeteria-manager', [
            'items' => CafeteriaItem::latest()->paginate(10)
        ]);
    }
}
