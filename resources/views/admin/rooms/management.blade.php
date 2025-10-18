@extends('admin.layout.app')

@section('breadcrumb')
    @include('admin.layout.partials.page-header', [
        'title' => 'Rooms Management',
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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoomModal">
                    Add new room
                </button>
            </div>
        </div>
        <div class="card-body">
            <livewire:tables.room-table />
        </div>
    </div>


    {{-- Create Modal --}}
    <div class="modal fade" id="createRoomModal" tabindex="-1" aria-labelledby="createRoomModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createRoomModal">
                        Add new room
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <livewire:dashboard.rooms.create />
            </div>
        </div>
    </div>


    {{-- Edit Modal --}}
    <div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editRoomModalLabel">
                        Edit Room
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <livewire:dashboard.rooms.edit />
            </div>
        </div>
    </div>


@endsection



@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            // ============== Close Create Modal ==============
            Livewire.on('closeCreateModal', (event) => {
                bootstrap.Modal.getInstance(document.getElementById('createRoomModal')).hide();
            });

            // ============== Open Edit Modal ==============
            Livewire.on('openEditRoomModal', (event) => {
                new bootstrap.Modal(document.getElementById('editRoomModal')).show();
                let room = event[0];
                Livewire.dispatch('setEditRoom', room);
            });

            // ============== Close Edit Modal ==============
            Livewire.on('closeEditModal', (event) => {
                bootstrap.Modal.getInstance(document.getElementById('editRoomModal')).hide();
            });
        });
    </script>
@endpush
