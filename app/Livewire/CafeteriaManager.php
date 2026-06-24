<?php

namespace App\Livewire;

use App\Models\CafeteriaItem;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class CafeteriaManager extends Component
{
    use WithPagination;

    public $name = '';
    public $barcode = '';
    public $price_per_item = '';
    public $cost_price = '';
    public $quantity = '';
    public $status = 1;
    public $editingId = null;
    public $showForm = false;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'barcode' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('cafeteria_items', 'barcode')->ignore($this->editingId),
            ],
            'price_per_item' => 'required|numeric|min:0.01',
            'cost_price' => 'nullable|numeric|min:0|lt:price_per_item',
            'quantity' => 'nullable|integer|min:0',
            'status' => 'required|boolean',
        ];
    }

    protected $messages = [
        'cost_price.lt' => 'Cost price must be less than price per item.',
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
        $this->barcode = $item->barcode ?? '';
        $this->price_per_item = $item->price_per_item;
        $this->cost_price = $item->cost_price ?? '';
        $this->quantity = $item->quantity ?? '';
        $this->status = $item->status;
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();

        $payload = [
            'name' => $this->name,
            'barcode' => $this->normalizeNullableText($this->barcode),
            'price_per_item' => $this->price_per_item,
            'cost_price' => $this->normalizeNullableNumber($this->cost_price),
            'quantity' => $this->normalizeNullableNumber($this->quantity),
            'status' => (bool) $this->status,
        ];

        if ($this->editingId) {
            $item = CafeteriaItem::findOrFail($this->editingId);
            $item->update($payload);
            session()->flash('message', 'Cafeteria item updated successfully!');
        } else {
            CafeteriaItem::create($payload);
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
        $this->reset(['name', 'barcode', 'price_per_item', 'cost_price', 'quantity', 'status', 'editingId', 'showForm']);
        $this->status = 1;
        $this->resetErrorBag();
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
        return view('livewire.cafeteria-manager', [
            'items' => CafeteriaItem::latest('created_at')->paginate(10)
        ]);
    }
}
