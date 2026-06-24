<div>
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

    @if (session()->has('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Gaming Session Info -->
    @if($session)
        <div class="card shadow-sm border-0 mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="card-title mb-3 d-flex align-items-center">
                            <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                                <i class="fas fa-desktop"></i>
                            </div>
                            <span>Gaming Session Details</span>
                        </h5>
                        <div class="row">
                            <div class="col-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-door-open me-2 opacity-75"></i>
                                    <div>
                                        <small class="opacity-75 d-block">Room</small>
                                        <div class="fw-semibold">{{ $session->room->name }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock me-2 opacity-75"></i>
                                    <div>
                                        <small class="opacity-75 d-block">Started</small>
                                        <div class="fw-semibold">{{ $session->started_at->format('H:i') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 text-md-end text-center mt-3 mt-md-0">
                        <button wire:click="goBack" class="btn btn-light btn-lg shadow-sm">
                            <i class="fas fa-times me-2"></i>
                            <span class="d-md-inline d-none">Close Window</span>
                            <span class="d-md-none">Close</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Search & Barcode Bar -->
    <div class="row mb-4 fade-in">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body py-3">
                    <div class="row align-items-center g-3">
                        <div class="col-md-6 col-12">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 ps-0 search-input" 
                                       placeholder="Search by name or barcode..." 
                                       wire:model.live.debounce.300ms="searchFilter"
                                       style="box-shadow: none;">
                                @if($searchFilter)
                                    <button class="btn btn-outline-secondary" 
                                            type="button" 
                                            wire:click="$set('searchFilter', '')"
                                            title="Clear search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-barcode text-primary"></i>
                                </span>
                                <input type="text"
                                       class="form-control"
                                       placeholder="Scan barcode + Enter"
                                       wire:model.defer="barcodeInput"
                                       wire:keydown.enter.prevent="addByBarcode"
                                       autocomplete="off">
                                <button class="btn btn-outline-primary" type="button" wire:click="addByBarcode">
                                    Add
                                </button>
                            </div>
                        </div>
                        <div class="col-md-2 col-12 text-md-end text-center">
                            <span class="text-muted">
                                <i class="fas fa-utensils me-1"></i>
                                {{ count($cafeteriaItems) }} items found
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cafeteria Items -->
    <div class="row g-4 mb-4">
        @forelse($cafeteriaItems as $item)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm card-item position-relative overflow-hidden">
                    
                    @if($selectedItems[$item->id]['quantity'] > 0)
                        <div class="position-absolute top-0 end-0 bg-primary text-white px-3 py-1 m-2 rounded-pill fs-6 fw-bold shadow quantity-badge">
                            {{ $selectedItems[$item->id]['quantity'] }}
                        </div>
                    @endif

                    <div class="card-body p-4">
                        <!-- Item Header -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-utensils text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex flex-column">
                                        <h6 class="card-title mb-1 fw-bold" style="color: #2d3748;">
                                            {{ $item->name }}
                                        </h6>
                                        <p class="text-muted small mb-0">
                                            {{ $item->formatted_price }} per item
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity Controls -->
                        <div class="row align-items-center">
                            <div class="col-8">
                                <div class="btn-group w-100 shadow-sm" role="group" style="border-radius: 12px; overflow: hidden;">
                                    <button type="button" 
                                            class="btn btn-outline-danger" 
                                            wire:click="decrementItem({{ $item->id }})"
                                            {{ $selectedItems[$item->id]['quantity'] <= 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="btn btn-light border-0 flex-fill fw-bold" 
                                          style="pointer-events: none;">
                                        {{ $selectedItems[$item->id]['quantity'] }}
                                    </span>
                                    <button type="button" 
                                            class="btn btn-outline-success" 
                                            wire:click="incrementItem({{ $item->id }})">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                @if($selectedItems[$item->id]['quantity'] > 0)
                                    <div class="fw-bold text-success fs-6">
                                        {{ number_format($selectedItems[$item->id]['total'], 2) }} JD
                                    </div>
                                @else
                                    <div class="text-muted small">
                                        Total
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Selected indicator -->
                    @if($selectedItems[$item->id]['quantity'] > 0)
                        <div class="position-absolute bottom-0 start-0 w-100 bg-primary" 
                             style="height: 4px; border-radius: 0 0 16px 16px;"></div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 20px;">
                    <div class="card-body py-5">
                        <div class="text-muted">
                            <div class="bg-light rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-utensils display-4 text-muted"></i>
                            </div>
                            <h6 class="fw-bold mb-2">No cafeteria items found</h6>
                            @if($searchFilter)
                                <p class="small mb-3">No items match your search for "{{ $searchFilter }}"</p>
                                <button wire:click="$set('searchFilter', '')" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-times me-1"></i>Clear search
                                </button>
                            @else
                                <p class="small">Please add some items first.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Totals Summary Card -->
    <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
        <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <h5 class="mb-0 d-flex align-items-center">
                <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                    <i class="fas fa-calculator"></i>
                </div>
                <span>Order Summary</span>
            </h5>
        </div>
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-6 col-12 mb-3 mb-md-0">
                    <div class="text-center p-3 rounded-3" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                        <i class="fas fa-desktop text-primary mb-2 fs-4"></i>
                        <div class="small text-muted">Gaming Price</div>
                        <div class="fw-bold fs-5">{{ number_format($totalGamingPrice, 2) }} JD</div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="text-center p-3 rounded-3" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                        <i class="fas fa-utensils text-primary mb-2 fs-4"></i>
                        <div class="small text-muted">Cafeteria Items</div>
                        <div class="fw-bold fs-5 text-primary">{{ number_format($totalCafeteriaPrice, 2) }} JD</div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mb-4 p-3 rounded-3" style="background: linear-gradient(135deg, #c8e6c9 0%, #a5d6a7 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-success">
                        <i class="fas fa-receipt me-2"></i>Grand Total:
                    </h5>
                    <h4 class="mb-0 text-success fw-bold">{{ number_format($grandTotal, 2) }} JD</h4>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row g-3">
                <div class="col-12">
                    <button wire:click="goBack" class="btn btn-light w-100 py-3 shadow-sm" style="border-radius: 12px;">
                        <i class="fas fa-times me-2"></i>Cancel & Go Back
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Fixed Floating Save Order Button -->
    <button wire:click="saveOrders" 
            class="btn btn-success floating-save-btn position-fixed"
            style="bottom: 20px; right: 20px; z-index: 1050; border-radius: 50px; padding: 15px 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.3); min-width: 200px; background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);">
        <span wire:loading.remove wire:target="saveOrders">
            <i class="fas fa-shopping-cart me-2"></i>
            Save Order
            @if($totalCafeteriaPrice > 0)
                <span class="badge bg-light text-success ms-2">{{ number_format($totalCafeteriaPrice, 2) }} JD</span>
            @endif
        </span>
        <span wire:loading wire:target="saveOrders">
            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
            Saving...
        </span>
    </button>

    @push('styles')
    <style>
        .transition-all {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        
        .btn-group .btn {
            transition: all 0.2s ease;
        }
        
        .btn-group .btn:hover {
            transform: scale(1.05);
            z-index: 1;
        }
        
        .search-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .card-item {
            transition: all 0.3s ease;
            border-radius: 16px;
        }
        
        .card-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        
        .quantity-badge {
            animation: pulse 0.5s ease-in-out;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Floating Save Button */
        .floating-save-btn {
            transition: all 0.3s ease;
            font-weight: 600;
            letter-spacing: 0.5px;
            border: none;
        }

        .floating-save-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.4) !important;
        }

        .floating-save-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: #6c757d !important;
        }

        .floating-save-btn .badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        @media (max-width: 768px) {
            .card-item .card-body {
                padding: 1rem;
            }
            
            .btn-group .btn {
                font-size: 0.875rem;
            }
            
            .search-bar {
                margin-bottom: 1rem;
            }

            .floating-save-btn {
                bottom: 15px !important;
                right: 15px !important;
                padding: 12px 16px !important;
                min-width: 160px !important;
                font-size: 0.9rem !important;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            // ============== Close Talabat Window ==============
            Livewire.on('closeTalabatWindow', () => {
                if (window.opener) {
                    window.close();
                } else {
                    window.location.href = '{{ route('dashboard') }}';
                }
            });
        });
    </script>
    @endpush
</div>