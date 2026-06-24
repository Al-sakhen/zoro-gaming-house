<?php

namespace App\Livewire\Tables;

use App\Models\CafeteriaItem;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class CafteriaItemTable extends PowerGridComponent
{
    public string $tableName = 'cafteria-item-table-wxcjxp-table';

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    #[On('refreshTable')]
    public function datasource(): Builder
    {
        return CafeteriaItem::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('barcode')
            ->add('price_per_item')
            ->add('price_formatted', function (CafeteriaItem $model) {
                return number_format($model->price_per_item, 2) . ' JD';
            })
            ->add('cost_price')
            ->add('cost_price_formatted', function (CafeteriaItem $model) {
                return $model->cost_price !== null
                    ? number_format($model->cost_price, 2) . ' JD'
                    : '-';
            })
            ->add('quantity')
            ->add('quantity_formatted', function (CafeteriaItem $model) {
                return $model->quantity !== null ? (string) $model->quantity : '-';
            })

            ->add('created_at_formatted', function (CafeteriaItem $model) {
                return Carbon::parse($model->created_at)->format('M d, Y');
            })
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::action('Action'),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Price per item', 'price_formatted', 'price_per_item')
                ->sortable()
                ->searchable(),

            Column::make('Cost price', 'cost_price_formatted', 'cost_price')
                ->sortable(),

            Column::make('Stock qty', 'quantity_formatted', 'quantity')
                ->sortable(),

            Column::make('Status', 'status')
                ->toggleable(
                    hasPermission: true,
                    trueLabel: '<span class="text-green-500">Active</span>',
                    falseLabel: '<span class="text-red-500">Inactive</span>',
                ),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

        ];
    }


    public function onUpdatedToggleable($id, $field, $value): void
    {
        CafeteriaItem::query()->find($id)->update([
            $field => $value,
        ]);
        $this->dispatch('success', 'Status updated successfully');
    }


    public function filters(): array
    {
        return [];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->dispatch('openEditCafeteriaModal', ['item' => $rowId]);
    }

    #[\Livewire\Attributes\On('viewStockMovements')]
    public function viewStockMovements($rowId): void
    {
        $this->dispatch('openStockMovementsCafeteriaModal', ['item' => $rowId]);
    }

    #[\Livewire\Attributes\On('openStockControl')]
    public function openStockControl($rowId): void
    {
        $this->dispatch('openStockControlCafeteriaModal', ['item' => $rowId]);
    }

    public function actions(CafeteriaItem $row): array
    {
        return [
            Button::add('edit')
                ->slot('<i class="fas fa-edit"></i>')
                ->class('btn btn-primary btn-sm rounded')
                ->dispatch('edit', ['rowId' => $row->id]),
            Button::add('stock-movements')
                ->slot('<i class="fas fa-chart-line"></i>')
                ->class('btn btn-info btn-sm rounded ms-1')
                ->dispatch('viewStockMovements', ['rowId' => $row->id]),
            Button::add('stock-control')
                ->slot('<i class="fas fa-cogs"></i>')
                ->class('btn btn-success btn-sm rounded ms-1')
                ->dispatch('openStockControl', ['rowId' => $row->id]),
        ];
    }
}
