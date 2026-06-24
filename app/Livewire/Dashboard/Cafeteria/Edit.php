<?php

namespace App\Livewire\Dashboard\Cafeteria;

use App\Models\CafeteriaItem;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public $cafeteriaItemId;
    public $name = '';
    public $barcode = '';
    public $price_per_item = '';
    public $cost_price = '';
    public $status = 1;

    protected $listeners = ['setEditCafeteriaItem'];

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'barcode' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('cafeteria_items', 'barcode')->ignore($this->cafeteriaItemId),
            ],
            'price_per_item' => 'required|numeric|min:0.01',
            'cost_price' => 'nullable|numeric|min:0|lt:price_per_item',
            'status' => 'required|boolean',
        ];
    }

    protected $messages = [
        'cost_price.lt' => 'Cost price must be less than price per item.',
    ];

    #[On('setEditCafeteriaItem')]
    public function setEditCafeteriaItem(CafeteriaItem $item)
    {
        $this->cafeteriaItemId = $item->id;
        $this->name = $item->name;
        $this->barcode = $item->barcode ?? '';
        $this->price_per_item = $item->price_per_item;
        $this->cost_price = $item->cost_price ?? '';
        $this->status = $item->status;
    }

    public function update()
    {
        $this->validate();

        $cafeteriaItem = CafeteriaItem::findOrFail($this->cafeteriaItemId);

        $cafeteriaItem->update([
            'name' => $this->name,
            'barcode' => $this->normalizeNullableText($this->barcode),
            'price_per_item' => $this->price_per_item,
            'cost_price' => $this->normalizeNullableNumber($this->cost_price),
            'status' => (bool) $this->status,
        ]);

        $this->dispatch('success', 'Cafeteria item updated successfully!');
        $this->dispatch('refreshTable');
        $this->dispatch('closeEditModal');
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
        return view('livewire.dashboard.cafeteria.edit');
    }
}
