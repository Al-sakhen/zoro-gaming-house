<?php

namespace App\Livewire\Tables;

use App\Models\Room;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class RoomTable extends PowerGridComponent
{
    public string $tableName = 'room-table-jttsoe-table';

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
        return Room::query();
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
            ->add('type', function (Room $model) {
                $type = $model->type ?? 'pc'; // Default to 'pc' if null
                switch ($type) {
                    case 'playstation':
                        return '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800"><i class="fab fa-playstation mr-1"></i>PlayStation</span>';
                    case 'pc':
                        return '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800"><i class="fas fa-desktop mr-1"></i>PC</span>';
                    case 'tables':
                        return '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800"><i class="fas fa-table mr-1"></i>Tables</span>';
                    default:
                        return '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">PC</span>';
                }
            })


            ->add('pricing_list', function (Room $model) {
                $type = $model->type ?? 'pc';
                if ($type === 'tables') {
                    return 'Free';
                } elseif ($type === 'playstation') {
                    $pricing = [];
                    if ($model->price_per_hour_2_controllers && $model->price_per_hour_2_controllers > 0) {
                        $pricing[] = '2P: ' . number_format((float)$model->price_per_hour_2_controllers, 2) . " JD";
                    }
                    if ($model->price_per_hour_4_controllers && $model->price_per_hour_4_controllers > 0) {
                        $pricing[] = '4P: ' . number_format((float)$model->price_per_hour_4_controllers, 2) . " JD";
                    }
                    if (!empty($pricing)) {
                        return implode(' | ', $pricing);
                    } else {
                        return  number_format((float)$model->price_per_hour, 2) . " JD";
                    }
                } else {
                    return  number_format((float)$model->price_per_hour, 2) . " JD";
                }
            })
            ->add('is_vip')
            ->add('status', function (Room $model) {
                $status = $model->status;
                switch ($status) {
                    case 'available':
                        return '<span class="text-green-500 font-bold">Available</span>';
                    case 'occupied':
                        return '<span class="text-red-500 font-bold">Occupied</span>';
                    case 'maintenance':
                        return '<span class="text-yellow-500 font-bold">Maintenance</span>';
                    default:
                        return '<span class="text-gray-500 font-bold">Unknown</span>';
                }
            })
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Type', 'type')
                ->sortable()
                ->searchable(),

            Column::make('Pricing', 'pricing_list'),

            Column::make('Is VIP', 'is_vip')
                ->toggleable(
                    hasPermission: true,
                    trueLabel: '<span class="text-green-500">Yes</span>',
                    falseLabel: '<span class="text-red-500">No</span>',
                ),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }


    public function onUpdatedToggleable($id, $field, $value): void
    {
        Room::query()->find($id)->update([
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
        $this->dispatch('openEditRoomModal', ['room' => $rowId]);
    }

    public function actions(Room $row): array
    {
        return [
            Button::add('edit')
                ->slot('<i class="fas fa-edit"></i>')
                ->class('btn btn-primary btn-sm rounded')
                ->dispatch('edit', ['rowId' => $row->id]),
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
