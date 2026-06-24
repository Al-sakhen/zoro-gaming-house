<?php

namespace App\Livewire\Dashboard\Cafeteria;

use App\Models\CafeteriaItem;
use Livewire\Component;

class Create extends Component
{
    public $name = '';
    public $barcode = '';
    public $price_per_item = '';
    public $cost_price = '';
    public $quantity = '';
    public $status = 1;

    protected $rules = [
        'name' => 'required|string|max:255',
        'barcode' => ['nullable', 'string', 'max:255', 'unique:cafeteria_items,barcode'],
        'price_per_item' => 'required|numeric|min:0.01',
        'cost_price' => 'nullable|numeric|min:0|lt:price_per_item',
        'quantity' => 'nullable|integer|min:0',
        'status' => 'required|boolean',
    ];

    protected $messages = [
        'cost_price.lt' => 'Cost price must be less than price per item.',
    ];

    public function save()
    {
        $this->validate();

        CafeteriaItem::create([
            'name' => $this->name,
            'barcode' => $this->normalizeNullableText($this->barcode),
            'price_per_item' => $this->price_per_item,
            'cost_price' => $this->normalizeNullableNumber($this->cost_price),
            'quantity' => $this->normalizeNullableNumber($this->quantity),
            'status' => (bool) $this->status,
        ]);

        $this->dispatch('success', 'Cafeteria item created successfully!');
        $this->dispatch('refreshTable');
        $this->dispatch('closeCreateModal');
        $this->reset();
    }

    private function normalizeNullableText($value): ?string
    {
        $value = is_string($value) ? trim($value) : $value;
        return $value === '' ? null : $value;
    }

    private function normalizeNullableNumber($value): int|float|null
    {
        return $value === '' || $value === null ? null : $value;
    }

    public function render()
    {
        return view('livewire.dashboard.cafeteria.create');
    }
}
