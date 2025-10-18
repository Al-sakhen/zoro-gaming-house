<div>
    <div class="modal-body">
        <form wire:submit.prevent="save">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            wire:model="name" placeholder="Enter item name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="price_per_item" class="form-label">Price per Item (JD) <span
                                class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0.01"
                            class="form-control @error('price_per_item') is-invalid @enderror" id="price_per_item"
                            wire:model="price_per_item" placeholder="0.00">
                        @error('price_per_item')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status"
                            wire:model="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" wire:click="save" class="btn btn-primary">
            <span wire:loading.remove wire:target="save">Save Cafeteria Item</span>
            <span wire:loading wire:target="save">
                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                Saving...
            </span>
        </button>
    </div>

</div>
