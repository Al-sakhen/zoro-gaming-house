<?php

namespace App\Livewire\Dashboard\Cafeteria;

use App\Models\CafeteriaItem;
use App\Services\StockService;
use Livewire\Attributes\On;
use Livewire\Component;

class StockControl extends Component
{
    public $cafeteriaItemId = null;
    public $itemName = '';
    public $currentQuantity = 0;
    public $step = 1;
    public $setQuantity = '';

    protected function rules(): array
    {
        return [
            'step' => 'required|integer|min:1|max:1000000',
            'setQuantity' => 'nullable|integer|min:0|max:1000000',
        ];
    }

    #[On('setStockControlCafeteriaItem')]
    public function setStockControlCafeteriaItem(CafeteriaItem $item): void
    {
        $this->cafeteriaItemId = $item->id;
        $this->itemName = $item->name;
        $this->currentQuantity = (int) ($item->quantity ?? 0);
        $this->step = 1;
        $this->setQuantity = (string) $this->currentQuantity;
    }

    public function increment(): void
    {
        $this->validateOnly('step');
        $this->applyDelta((int) $this->step);
    }

    public function decrement(): void
    {
        $this->validateOnly('step');
        $this->applyDelta(-1 * (int) $this->step);
    }

    public function setAbsolute(): void
    {
        $this->validateOnly('setQuantity');

        if ($this->cafeteriaItemId === null || $this->setQuantity === '') {
            return;
        }

        $result = app(StockService::class)->setAbsoluteQuantity(
            (int) $this->cafeteriaItemId,
            (int) $this->setQuantity,
            'stock_control_modal_set',
            'Manual stock set from modal'
        );

        $this->currentQuantity = (int) $result['after'];
        $this->setQuantity = (string) $this->currentQuantity;

        $this->dispatch('success', "Stock set to {$this->currentQuantity} for {$this->itemName}.");
        $this->dispatch('refreshTable');
        $this->dispatch('stockControlUpdated');
        $this->dispatch('closeStockControlModal');
    }

    private function applyDelta(int $delta): void
    {
        if ($this->cafeteriaItemId === null || $delta === 0) {
            return;
        }

        $result = app(StockService::class)->applyManualDelta(
            (int) $this->cafeteriaItemId,
            $delta,
            'stock_control_modal_delta',
            'Manual stock delta from modal'
        );

        $this->currentQuantity = (int) $result['after'];
        $this->setQuantity = (string) $this->currentQuantity;

        $verb = $delta > 0 ? 'added' : 'removed';
        $value = abs($delta);
        $this->dispatch('success', "Successfully {$verb} {$value} for {$this->itemName}. Current stock: {$this->currentQuantity}");
        $this->dispatch('refreshTable');
        $this->dispatch('stockControlUpdated');
        $this->dispatch('closeStockControlModal');
    }

    public function render()
    {
        return view('livewire.dashboard.cafeteria.stock-control');
    }
}
