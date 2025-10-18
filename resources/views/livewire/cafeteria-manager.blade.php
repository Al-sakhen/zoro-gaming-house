<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">
                    <i class="fas fa-utensils me-2"></i>
                    Cafeteria Items
                </h2>
                <button wire:click="addNew" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Item
                </button>
            </div>

            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Form Modal -->
            @if($showForm)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            {{ $editingId ? 'Edit Item' : 'Add New Item' }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="save">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               wire:model="name" 
                                               placeholder="Enter item name">
                                        @error('name') 
                                            <div class="invalid-feedback">{{ $message }}</div> 
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price per Item (JD)</label>
                                        <input type="number" 
                                               step="0.01" 
                                               min="0.01"
                                               class="form-control @error('price_per_item') is-invalid @enderror" 
                                               id="price" 
                                               wire:model="price_per_item" 
                                               placeholder="0.00">
                                        @error('price_per_item') 
                                            <div class="invalid-feedback">{{ $message }}</div> 
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select @error('status') is-invalid @enderror" 
                                                id="status" 
                                                wire:model="status">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                        @error('status') 
                                            <div class="invalid-feedback">{{ $message }}</div> 
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">&nbsp;</label>
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save"></i>
                                            </button>
                                            <button type="button" wire:click="resetForm" class="btn btn-secondary">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Items Table -->
            <div class="card">
                <div class="card-body">
                    @if($items->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Price per Item</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td>
                                                <strong>{{ $item->name }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">
                                                    {{ $item->formatted_price }}
                                                </span>
                                            </td>
                                            <td>
                                                <button wire:click="toggleStatus({{ $item->id }})" 
                                                        class="btn btn-sm {{ $item->status ? 'btn-success' : 'btn-secondary' }}">
                                                    {{ $item->status ? 'Active' : 'Inactive' }}
                                                </button>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $item->created_at->format('M d, Y') }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button wire:click="edit({{ $item->id }})" 
                                                            class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button wire:click="delete({{ $item->id }})" 
                                                            onclick="return confirm('Are you sure you want to delete this item?')"
                                                            class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $items->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="text-muted display-1 mb-3">🍽️</div>
                            <h5 class="fw-medium mb-2">No Cafeteria Items</h5>
                            <p class="text-muted">Start by adding your first cafeteria item.</p>
                            <button wire:click="addNew" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Add First Item
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
