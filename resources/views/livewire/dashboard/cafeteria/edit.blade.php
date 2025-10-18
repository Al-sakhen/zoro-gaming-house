<div>
    <div class="modal-body">
        <form wire:submit.prevent="update">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="edit_name"
                            wire:model="name" placeholder="Enter item name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="edit_price_per_item" class="form-label">Price per Item (JD) <span
                                class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0.01"
                            class="form-control @error('price_per_item') is-invalid @enderror" id="edit_price_per_item"
                            wire:model="price_per_item" placeholder="0.00">
                        @error('price_per_item')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="edit_status"
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
        <button type="button" wire:click="update" class="btn btn-primary">
            <span wire:loading.remove wire:target="update">Update Cafeteria Item</span>
            <span wire:loading wire:target="update">
                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                Updating...
            </span>
        </button>
    </div>

</div>
