<div>
    <div class="modal-header bg-primary text-white">
        <h1 class="modal-title fs-5 d-flex align-items-center">
            <i class="fas fa-utensils me-2"></i>
            Talabat Order
            @if($session)
                - {{ $session->room->name }}
            @endif
        </h1>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" 
                wire:click="resetSelectedItems"></button>
    </div>

    <div class="modal-body">
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Gaming Session Info -->
        @if($session)
            <div class="card bg-light mb-4">
                <div class="card-body">
                    <h6 class="card-title text-primary">
                        <i class="fas fa-desktop me-2"></i>Gaming Session
                    </h6>
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Room:</small>
                            <div class="fw-semibold">{{ $session->room->name }}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Gaming Price:</small>
                            <div class="fw-semibold text-success">{{ number_format($totalGamingPrice, 2) }} JD</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Cafeteria Items -->
        <div class="row g-3">
            @forelse($cafeteriaItems as $item)
                <div class="col-12 col-md-6">
                    <div class="card border {{ $selectedItems[$item->id]['quantity'] > 0 ? 'border-primary' : '' }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h6 class="card-title mb-1">{{ $item->name }}</h6>
                                    <p class="text-muted small mb-0">{{ $item->formatted_price }} per item</p>
                                </div>
                                @if($selectedItems[$item->id]['quantity'] > 0)
                                    <span class="badge bg-primary">{{ $selectedItems[$item->id]['quantity'] }}</span>
                                @endif
                            </div>

                            <!-- Quantity Controls -->
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-danger btn-sm" 
                                            wire:click="decrementItem({{ $item->id }})"
                                            {{ $selectedItems[$item->id]['quantity'] <= 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="btn btn-outline-secondary btn-sm disabled">
                                        {{ $selectedItems[$item->id]['quantity'] }}
                                    </span>
                                    <button type="button" class="btn btn-outline-success btn-sm" 
                                            wire:click="incrementItem({{ $item->id }})">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                @if($selectedItems[$item->id]['quantity'] > 0)
                                    <span class="fw-semibold text-success">
                                        {{ number_format($selectedItems[$item->id]['total'], 2) }} JD
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4">
                    <div class="text-muted">
                        <i class="fas fa-utensils display-4 mb-3"></i>
                        <h6>No cafeteria items available</h6>
                        <p class="small">Please add some items first.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="modal-footer bg-light">
        <!-- Totals Summary -->
        <div class="w-100">
            <div class="row mb-3">
                <div class="col-6">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Gaming:</span>
                        <span class="fw-semibold">{{ number_format($totalGamingPrice, 2) }} JD</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Cafeteria:</span>
                        <span class="fw-semibold text-primary">{{ number_format($totalCafeteriaPrice, 2) }} JD</span>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                <h6 class="mb-0">Grand Total:</h6>
                <h5 class="mb-0 text-success">{{ number_format($grandTotal, 2) }} JD</h5>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="w-100 d-flex gap-2 mt-3">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" 
                    wire:click="resetSelectedItems">
                Cancel
            </button>
            <button type="button" class="btn btn-primary flex-fill" 
                    wire:click="saveOrders"
                    {{ $totalCafeteriaPrice <= 0 ? 'disabled' : '' }}>
                <i class="fas fa-shopping-cart me-2"></i>
                Add to Order ({{ number_format($totalCafeteriaPrice, 2) }} JD)
            </button>
        </div>
    </div>

    @if(session('closeModal'))
        <script>
            // Close modal after successful save
            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.querySelector('.modal'));
                if (modal) {
                    modal.hide();
                }
            }, 1000);
        </script>
    @endif
</div>
