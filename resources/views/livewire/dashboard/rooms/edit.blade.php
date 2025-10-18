<div class="modal-body">
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form wire:submit.prevent="update">
        <div class="row">
            <!-- Room Name -->
            <div class="col-md-6 mb-3">
                <label for="edit_name" class="form-label">Room Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="edit_name"
                    wire:model="name" placeholder="Enter room name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Room Type -->
            <div class="col-md-6 mb-3">
                <label for="edit_type" class="form-label">Room Type <span class="text-danger">*</span></label>
                <select class="form-select @error('type') is-invalid @enderror" id="edit_type" wire:model="type">
                    <option value="pc">PC</option>
                    <option value="playstation">PlayStation</option>
                    <option value="tables">Tables</option>
                </select>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            @if (in_array($type, ['pc', 'tables']))
                <!-- Price Per Hour -->
                <div class="col-md-6 mb-3">
                    <label for="edit_price_per_hour" class="form-label">
                        @if ($type === 'tables')
                            Price Per Hour (Leave 0 for free tables) <span class="text-danger">*</span>
                        @elseif($type === 'playstation')
                            Base Price Per Hour (Optional - can use controller-specific pricing)
                        @else
                            Price Per Hour <span class="text-danger">*</span>
                        @endif
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control @error('price_per_hour') is-invalid @enderror"
                            id="edit_price_per_hour" wire:model="price_per_hour" step="0.01" min="0"
                            placeholder="0.00">
                        @error('price_per_hour')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @if ($type === 'playstation')
                        <small class="form-text text-muted">This will be used as fallback if controller-specific prices
                            are not set</small>
                    @endif
                </div>
            @endif

            <!-- Status -->
            <div class="col-md-6 mb-3">
                <label for="edit_status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select @error('status') is-invalid @enderror" id="edit_status" wire:model="status">
                    <option value="">Select status</option>
                    <option value="available">Available</option>
                    <option value="occupied">Occupied</option>
                    <option value="maintenance">Maintenance</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        @if ($type === 'playstation')
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fab fa-playstation me-2"></i>PlayStation Pricing</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Price for 2 Controllers -->
                                <div class="col-md-6 mb-3">
                                    <label for="edit_price_per_hour_2_controllers" class="form-label">Price for 2
                                        Controllers</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number"
                                            class="form-control @error('price_per_hour_2_controllers') is-invalid @enderror"
                                            id="edit_price_per_hour_2_controllers"
                                            wire:model="price_per_hour_2_controllers" step="0.01" min="0"
                                            placeholder="0.00">
                                        @error('price_per_hour_2_controllers')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Price for 4 Controllers -->
                                <div class="col-md-6 mb-3">
                                    <label for="edit_price_per_hour_4_controllers" class="form-label">Price for 4
                                        Controllers</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number"
                                            class="form-control @error('price_per_hour_4_controllers') is-invalid @enderror"
                                            id="edit_price_per_hour_4_controllers"
                                            wire:model="price_per_hour_4_controllers" step="0.01" min="0"
                                            placeholder="0.00">
                                        @error('price_per_hour_4_controllers')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Room Type</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="edit_is_vip" wire:model="is_vip">
                    <label class="form-check-label" for="edit_is_vip">
                        VIP Room
                    </label>
                </div>
                <small class="form-text text-muted">Check if this is a VIP room</small>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row">
            <div class="col-12">
                <hr>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Room
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
