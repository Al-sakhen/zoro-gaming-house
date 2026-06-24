<?php

namespace App\Livewire\Dashboard\Cafeteria;

use App\Models\CafeteriaItem;
use App\Models\StockMovement;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class StockMovements extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';

    public $cafeteriaItemId = null;
    public $itemName = '';
    public $movementType = '';
    public $source = '';
    public $sessionId = '';
    public $dateFrom = '';
    public $dateTo = '';

    #[On('setStockMovementCafeteriaItem')]
    public function setStockMovementCafeteriaItem(CafeteriaItem $item): void
    {
        $this->cafeteriaItemId = $item->id;
        $this->itemName = $item->name;
        $this->resetPage();
        $this->resetFilters();
    }

    public function resetFilters(): void
    {
        $this->movementType = '';
        $this->source = '';
        $this->sessionId = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    public function updatedMovementType(): void
    {
        $this->resetPage();
    }

    public function updatedSource(): void
    {
        $this->resetPage();
    }

    public function updatedSessionId(): void
    {
        $this->resetPage();
    }

    public function updatedDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatedDateTo(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $movements = null;

        if ($this->cafeteriaItemId) {
            $query = StockMovement::query()
                ->with('session')
                ->where('cafeteria_item_id', $this->cafeteriaItemId)
                ->when($this->movementType !== '', function ($builder) {
                    $builder->where('movement_type', $this->movementType);
                })
                ->when($this->source !== '', function ($builder) {
                    $builder->where('source', 'like', '%' . trim($this->source) . '%');
                })
                ->when($this->sessionId !== '', function ($builder) {
                    $builder->where('session_id', (int) $this->sessionId);
                })
                ->when($this->dateFrom !== '', function ($builder) {
                    $builder->whereDate('created_at', '>=', $this->dateFrom);
                })
                ->when($this->dateTo !== '', function ($builder) {
                    $builder->whereDate('created_at', '<=', $this->dateTo);
                })
                ->latest('id');

            $movements = $query->paginate(20);
        }

        return view('livewire.dashboard.cafeteria.stock-movements', [
            'movements' => $movements,
        ]);
    }
}
