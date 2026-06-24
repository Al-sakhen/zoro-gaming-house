@extends('admin.layout.app')

@section('breadcrumb')
    @include('admin.layout.partials.page-header', [
        'title' => 'Cafeteria Management',
        'links' => [
            [
                'name' => 'Dashboard',
                'url' => route('dashboard'),
            ],
        ],
    ])
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCafeteriaModal">
                    Add new cafeteria item
                </button>
            </div>
        </div>
        <div class="card-body">
            <livewire:tables.cafteria-item-table />
        </div>
    </div>

    {{-- Create Modal --}}
    <div class="modal fade" id="createCafeteriaModal" tabindex="-1" aria-labelledby="createCafeteriaModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createCafeteriaModal">
                        Add new cafeteria item
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <livewire:dashboard.cafeteria.create />
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editCafeteriaModal" tabindex="-1" aria-labelledby="editCafeteriaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editCafeteriaModalLabel">
                        Edit Cafeteria Item
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <livewire:dashboard.cafeteria.edit />
            </div>
        </div>
    </div>

    {{-- Stock Movements Modal --}}
    <div class="modal fade" id="stockMovementsCafeteriaModal" tabindex="-1" aria-labelledby="stockMovementsCafeteriaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="stockMovementsCafeteriaModalLabel">
                        Stock Movements
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <livewire:dashboard.cafeteria.stock-movements />
            </div>
        </div>
    </div>

    {{-- Stock Control Modal --}}
    <div class="modal fade" id="stockControlCafeteriaModal" tabindex="-1" aria-labelledby="stockControlCafeteriaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-light">
                    <h1 class="modal-title fs-5" id="stockControlCafeteriaModalLabel">
                        Stock Control
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <livewire:dashboard.cafeteria.stock-control />
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            // ============== Close Create Modal ==============
            Livewire.on('closeCreateModal', (event) => {
                bootstrap.Modal.getInstance(document.getElementById('createCafeteriaModal')).hide();
            });

            // ============== Open Edit Modal ==============
            Livewire.on('openEditCafeteriaModal', (event) => {
                new bootstrap.Modal(document.getElementById('editCafeteriaModal')).show();
                let item = event[0];
                Livewire.dispatch('setEditCafeteriaItem', item);
            });

            // ============== Close Edit Modal ==============
            Livewire.on('closeEditModal', (event) => {
                bootstrap.Modal.getInstance(document.getElementById('editCafeteriaModal')).hide();
            });

            // ============== Open Stock Movements Modal ==============
            Livewire.on('openStockMovementsCafeteriaModal', (event) => {
                new bootstrap.Modal(document.getElementById('stockMovementsCafeteriaModal')).show();
                let item = event[0];
                Livewire.dispatch('setStockMovementCafeteriaItem', item);
            });

            // ============== Close Stock Movements Modal ==============
            Livewire.on('closeStockMovementsModal', (event) => {
                bootstrap.Modal.getInstance(document.getElementById('stockMovementsCafeteriaModal')).hide();
            });

            // ============== Open Stock Control Modal ==============
            Livewire.on('openStockControlCafeteriaModal', (event) => {
                new bootstrap.Modal(document.getElementById('stockControlCafeteriaModal')).show();
                let item = event[0];
                Livewire.dispatch('setStockControlCafeteriaItem', item);
            });

            // ============== Close Stock Control Modal ==============
            Livewire.on('closeStockControlModal', (event) => {
                bootstrap.Modal.getInstance(document.getElementById('stockControlCafeteriaModal')).hide();
            });
        });
    </script>
@endpush
