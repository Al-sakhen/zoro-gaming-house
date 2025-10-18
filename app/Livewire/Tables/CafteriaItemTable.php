<?php

namespace App\Livewire\Tables;

use App\Models\CafeteriaItem;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
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
            ->add('price_per_item')
            ->add('price_formatted', function (CafeteriaItem $model) {
                return number_format($model->price_per_item, 2) . ' JD';
            })
        
            ->add('created_at_formatted', function (CafeteriaItem $model) {
                return Carbon::parse($model->created_at)->format('M d, Y');
            })
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Price per item', 'price_formatted', 'price_per_item')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status')
                ->toggleable(
                    hasPermission: true,
                    trueLabel: '<span class="text-green-500">Active</span>',
                    falseLabel: '<span class="text-red-500">Inactive</span>',
                ),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Action')
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

    public function actions(CafeteriaItem $row): array
    {
        return [
            Button::add('edit')
                ->slot('<i class="fas fa-edit"></i>')
                ->class('btn btn-primary btn-sm rounded')
                ->dispatch('edit', ['rowId' => $row->id]),
        ];
    }
}
