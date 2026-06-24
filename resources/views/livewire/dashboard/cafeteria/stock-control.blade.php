<div>
    <div class="modal-body">
        @if (!$cafeteriaItemId)
            <div class="alert alert-info mb-0">Select an item to control stock.</div>
        @else
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #f8fbff 0%, #eef5ff 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-0">{{ $itemName }}</h5>
                            <small class="text-muted">Live stock control</small>
                        </div>
                        <span class="badge rounded-pill text-bg-dark px-3 py-2 fs-6">
                            Current: {{ $currentQuantity }}
                        </span>
                    </div>

                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label" for="stock_step">Step</label>
                            <input id="stock_step" type="number" min="1" class="form-control @error('step') is-invalid @enderror" wire:model="step">
                            @error('step')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-success flex-fill" wire:click="increment">
                                    <span wire:loading.remove wire:target="increment">+ Add Stock</span>
                                    <span wire:loading wire:target="increment">
                                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                        Applying...
                                    </span>
                                </button>
                                <button type="button" class="btn btn-outline-danger flex-fill" wire:click="decrement">
                                    <span wire:loading.remove wire:target="decrement">- Remove Stock</span>
                                    <span wire:loading wire:target="decrement">
                                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                        Applying...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row g-3 align-items-end">
                        <div class="col-md-8">
                            <label class="form-label" for="absolute_stock">Set Absolute Quantity</label>
                            <input id="absolute_stock" type="number" min="0" class="form-control @error('setQuantity') is-invalid @enderror" wire:model="setQuantity">
                            @error('setQuantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary w-100" wire:click="setAbsolute">
                                <span wire:loading.remove wire:target="setAbsolute">Set Quantity</span>
                                <span wire:loading wire:target="setAbsolute">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    Saving...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</div>
