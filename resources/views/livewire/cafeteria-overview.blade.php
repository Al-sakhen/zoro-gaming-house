@push('styles')
    <style>
        /* Modern Cafeteria Overview Styling */
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }

        .cafeteria-container {
            background-image: url('/gaming-bg.svg');
            background-size: 100px 100px;
            background-repeat: repeat;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
        }

        .cafeteria-container::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            pointer-events: none;
            z-index: 0;
        }

        .container-fluid {
            position: relative;
            z-index: 1;
        }

        /* Modern Card Styling */
        .modern-card {
            border-radius: 24px;
            overflow: hidden;
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: none;
            animation: fadeIn 0.6s ease-out;
        }

        /* Modern Header */
        .modern-header {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .modern-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            transform: rotate(45deg);
        }

        .modern-header h3 {
            position: relative;
            z-index: 1;
            margin: 0;
            font-weight: 700;
        }

        /* Statistics Cards */
        .stat-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 16px;
            padding: 1rem;
            border: none;
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
            flex-shrink: 0;
        }

        .stat-icon.bg-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-icon.bg-success {
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
        }

        .stat-icon.bg-warning {
            background: linear-gradient(135deg, #ffd93d 0%, #ff9500 100%);
        }

        .stat-icon.bg-info {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        }

        /* Order Cards */
        .order-card {
            border-radius: 16px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgb(207, 28, 28);
            height: 100%;
        }

        .order-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .order-header {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
            padding: 1rem;
            position: relative;
            overflow: hidden;
        }

        /* Filters Section */
        .filters-section {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .modern-input {
            border-radius: 12px;
            border: 2px solid rgba(255, 107, 107, 0.2);
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .modern-input:focus {
            border-color: #ff6b6b;
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.25);
            outline: none;
        }

        /* Badges */
        .modern-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* Sort Buttons */
        .sort-btn {
            background: rgba(255, 107, 107, 0.1);
            border: 1px solid rgba(255, 107, 107, 0.3);
            color: #ff6b6b;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }

        .sort-btn:hover {
            background: #ff6b6b;
            color: white;
            transform: translateY(-2px);
        }

        .sort-btn.active {
            background: #ff6b6b;
            color: white;
        }

        /* Price Display */
        .price-display {
            color: #ff6b6b;
            font-weight: 700;
            font-size: 1.1rem;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .modern-header {
                padding: 1rem;
            }

            .filters-section {
                padding: 1rem;
            }

            .stat-card {
                margin-bottom: 1rem;
            }
        }
    </style>
@endpush

<div class="cafeteria-container">
    <div class="container-fluid py-4 fade-in">
        <div class="row">
            <div class="col-12">
                <div class="card modern-card">
                    <div class="card-header modern-header bg-danger">
                        <h3 class="card-title mb-0 d-flex align-items-center text-white">
                            <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                                <i class="fas fa-chart-pie text-white"></i>
                            </div>
                            <span>Cafeteria Items Statistics</span>
                        </h3>
                        <div class="mt-2">
                            <span class="badge badge-success bg-opacity-20 text-white px-3 py-2 rounded-pill">
                                {{ $finalOrders->total() }} Unique Items
                            </span>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="card-body p-3">
                        <div class="row g-3 mb-3">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-icon bg-info">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold text-primary">
                                            {{ number_format($stats['total_orders']) }}</h5>
                                        <small class="text-muted fw-600">Total Orders</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-icon bg-success">
                                        <i class="fas fa-cubes"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold text-success">
                                            {{ number_format($stats['total_quantity']) }}</h5>
                                        <small class="text-muted fw-600">Total Quantity</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-icon bg-warning">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold text-warning">
                                            {{ number_format($stats['total_revenue'], 2) }} JD</h5>
                                        <small class="text-muted fw-600">Total Revenue</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-icon bg-primary">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold {{ $stats['actual_revenue'] >= 0 ? 'text-primary' : 'text-danger' }}">
                                            {{ number_format($stats['actual_revenue'], 2) }} JD
                                        </h5>
                                        <small class="text-muted fw-600">Actual Revenue</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-icon bg-primary">
                                        <i class="fas fa-list"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold text-primary">
                                            {{ number_format($stats['unique_items']) }}</h5>
                                        <small class="text-muted fw-600">Unique Items</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filters Section -->
                        <div class="filters-section">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-filter text-danger"></i>
                                </div>
                                <h5 class="text-danger mb-0 fw-bold">Filters & Search</h5>
                            </div>

                            <!-- Sort Options -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold text-muted">Sort By:</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button class="sort-btn {{ $sortField === 'item_name' ? 'active' : '' }}"
                                            wire:click="sortBy('item_name', '{{ $sortField === 'item_name' && $sortDirection === 'asc' ? 'desc' : 'asc' }}')">
                                            <i class="fas fa-utensils me-1"></i>Item Name
                                            @if ($sortField === 'item_name')
                                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                            @endif
                                        </button>
                                        <button class="sort-btn {{ $sortField === 'total_quantity' ? 'active' : '' }}"
                                            wire:click="sortBy('total_quantity', '{{ $sortField === 'total_quantity' && $sortDirection === 'desc' ? 'asc' : 'desc' }}')">
                                            <i class="fas fa-cubes me-1"></i>Total Quantity
                                            @if ($sortField === 'total_quantity')
                                                <i class="fas fa-sort-{{ $sortDirection === 'desc' ? 'down' : 'up' }} ms-1"></i>
                                            @endif
                                        </button>
                                        <button class="sort-btn {{ $sortField === 'total_revenue' ? 'active' : '' }}"
                                            wire:click="sortBy('total_revenue', '{{ $sortField === 'total_revenue' && $sortDirection === 'desc' ? 'asc' : 'desc' }}')">
                                            <i class="fas fa-money-bill me-1"></i>Total Revenue
                                            @if ($sortField === 'total_revenue')
                                                <i class="fas fa-sort-{{ $sortDirection === 'desc' ? 'down' : 'up' }} ms-1"></i>
                                            @endif
                                        </button>
                                        <button class="sort-btn {{ $sortField === 'actual_revenue' ? 'active' : '' }}"
                                            wire:click="sortBy('actual_revenue', '{{ $sortField === 'actual_revenue' && $sortDirection === 'desc' ? 'asc' : 'desc' }}')">
                                            <i class="fas fa-chart-line me-1"></i>Actual Revenue
                                            @if ($sortField === 'actual_revenue')
                                                <i class="fas fa-sort-{{ $sortDirection === 'desc' ? 'down' : 'up' }} ms-1"></i>
                                            @endif
                                        </button>
                                        <button class="sort-btn {{ $sortField === 'total_orders' ? 'active' : '' }}"
                                            wire:click="sortBy('total_orders', '{{ $sortField === 'total_orders' && $sortDirection === 'desc' ? 'asc' : 'desc' }}')">
                                            <i class="fas fa-shopping-cart me-1"></i>Total Orders
                                            @if ($sortField === 'total_orders')
                                                <i class="fas fa-sort-{{ $sortDirection === 'desc' ? 'down' : 'up' }} ms-1"></i>
                                            @endif
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-lg-2 col-md-6">
                                    <label for="search" class="form-label fw-bold">
                                        <i class="fas fa-search me-1"></i>Search
                                    </label>
                                    <input type="text" class="form-control modern-input" id="search"
                                        wire:model.live.debounce.300ms="search" placeholder="Search item name...">
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <label for="filterName" class="form-label fw-bold">
                                        <i class="fas fa-utensils me-1"></i>Item Name
                                    </label>
                                    <select class="form-control modern-input" id="filterName"
                                        wire:model.live="filterName">
                                        <option value="">All Items</option>
                                        @foreach($cafeteriaItems as $item)
                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="col-lg-1 col-md-6">
                                    <label for="filterMinQuantity" class="form-label fw-bold">
                                        <i class="fas fa-cubes me-1"></i>Min Qty
                                    </label>
                                    <input type="number" class="form-control modern-input" id="filterMinQuantity"
                                        wire:model.live="filterMinQuantity" placeholder="0" min="0">
                                </div>
                                <div class="col-lg-1 col-md-6">
                                    <label for="filterMaxQuantity" class="form-label fw-bold">Max Qty</label>
                                    <input type="number" class="form-control modern-input" id="filterMaxQuantity"
                                        wire:model.live="filterMaxQuantity" placeholder="999" min="0">
                                </div> --}}
                                <div class="col-lg-2 col-md-6">
                                    <label for="filterStartDate" class="form-label fw-bold">
                                        <i class="fas fa-calendar-alt me-1"></i>Start Date
                                    </label>
                                    <input type="date" class="form-control modern-input" id="filterStartDate"
                                        wire:model.live="filterStartDate">
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <label for="filterEndDate" class="form-label fw-bold">
                                        <i class="fas fa-calendar-check me-1"></i>End Date
                                    </label>
                                    <input type="date" class="form-control modern-input" id="filterEndDate"
                                        wire:model.live="filterEndDate">
                                </div>
                                <div class="col-lg-1 col-md-6">
                                    <label for="filterStartTime" class="form-label fw-bold">Start Time</label>
                                    <input type="time" class="form-control modern-input" id="filterStartTime"
                                        wire:model.live="filterStartTime">
                                </div>
                                <div class="col-lg-1 col-md-6">
                                    <label for="filterEndTime" class="form-label fw-bold">End Time</label>
                                    <input type="time" class="form-control modern-input" id="filterEndTime"
                                        wire:model.live="filterEndTime">
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <label class="form-label fw-bold">&nbsp;</label>
                                    <button type="button" class="btn btn-outline-danger w-100 rounded-pill"
                                        wire:click="clearFilters" title="Clear All Filters">
                                        <i class="fas fa-times"></i> Clear Filters
                                    </button>
                                </div>
                            </div>

                            <!-- Filter Summary -->
                            @if ($search || $filterName || $filterMinQuantity || $filterMaxQuantity || $filterStartDate || $filterEndDate || $filterStartTime || $filterEndTime)
                                <div class="mt-4">
                                    <div class="alert alert-danger border-0 rounded-4"
                                        style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-filter me-2 text-danger"></i>
                                            <strong class="text-danger">Active Filters:</strong>
                                        </div>
                                        <div class="mt-2">
                                            @if ($search)
                                                <span class="modern-badge bg-primary text-white me-2 mb-1">Search: {{ $search }}</span>
                                            @endif
                                            @if ($filterName)
                                                <span class="modern-badge bg-success text-white me-2 mb-1">Item: {{ $filterName }}</span>
                                            @endif
                                            @if ($filterMinQuantity)
                                                <span class="modern-badge bg-secondary text-white me-2 mb-1">Min Qty: {{ $filterMinQuantity }}</span>
                                            @endif
                                            @if ($filterMaxQuantity)
                                                <span class="modern-badge bg-secondary text-white me-2 mb-1">Max Qty: {{ $filterMaxQuantity }}</span>
                                            @endif
                                            @if ($filterStartDate)
                                                <span class="modern-badge bg-warning text-dark me-2 mb-1">From: {{ $filterStartDate }}{{ $filterStartTime ? ' ' . $filterStartTime : '' }}</span>
                                            @endif
                                            @if ($filterEndDate)
                                                <span class="modern-badge bg-warning text-dark me-2 mb-1">To: {{ $filterEndDate }}{{ $filterEndTime ? ' ' . $filterEndTime : '' }}</span>
                                            @endif
                                            @if ($filterStartTime && !$filterStartDate)
                                                <span class="modern-badge bg-info text-white me-2 mb-1">After: {{ $filterStartTime }}</span>
                                            @endif
                                            @if ($filterEndTime && !$filterEndDate)
                                                <span class="modern-badge bg-info text-white me-2 mb-1">Before: {{ $filterEndTime }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Cafeteria Items Grid -->
                        @if ($finalOrders->count() > 0)
                            <div class="row g-4">
                                @foreach ($finalOrders as $item)
                                    <div class="col-lg-3 col-md-6">
                                        <div class="order-card">
                                            <!-- Item Header -->
                                            <div class="order-header">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h5 class="mb-1 fw-bold">{{ $item->item_name }}</h5>
                                                        {{-- <small class="text-white">
                                                            <i class="fas fa-shopping-cart me-1"></i>{{ $item->total_orders }} orders placed
                                                        </small> --}}
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="badge bg-white text-danger fw-bold">
                                                            {{ number_format($item->total_quantity) }} units
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Card Body -->
                                            <div class="card-body p-3">
                                                <!-- Main Statistics -->
                                                <div class="row g-2 mb-3">
                                                    <div class="col-4">
                                                        <div class="text-center p-2 bg-light rounded">
                                                            <small class="text-muted d-block">Total Revenue</small>
                                                            <span class="fw-bold price-display">{{ number_format($item->total_revenue, 2) }} JD</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="text-center p-2 bg-light rounded">
                                                            <small class="text-muted d-block">Actual Revenue</small>
                                                            <span class="fw-bold {{ $item->actual_revenue >= 0 ? 'text-primary' : 'text-danger' }}">{{ number_format($item->actual_revenue, 2) }} JD</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="text-center p-2 bg-light rounded">
                                                            <small class="text-muted d-block">Avg Price/Unit</small>
                                                            <span class="fw-bold text-primary">{{ number_format($item->avg_price_per_unit, 2) }} JD</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Additional Statistics -->
                                                <div class="row g-2 mb-3">
                                                    <div class="col-6">
                                                        <div class="text-center p-2 bg-light rounded">
                                                            <small class="text-muted d-block">Total Orders</small>
                                                            <span class="fw-bold text-info">{{ $item->total_orders }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="text-center p-2 bg-light rounded">
                                                            <small class="text-muted d-block">Quantity</small>
                                                            <span class="fw-bold text-success">{{ number_format($item->total_quantity) }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Date Information -->
                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted mb-2">
                                                        <i class="fas fa-calendar-alt me-1"></i>Order History
                                                    </h6>
                                                    <div class="bg-light rounded p-2">
                                                        <div class="row g-1">
                                                            <div class="col-6">
                                                                <small class="text-muted">First Order:</small>
                                                                <div class="fw-bold">{{ \Carbon\Carbon::parse($item->first_order_date)->format('M d, Y') }}</div>
                                                            </div>
                                                            <div class="col-6">
                                                                <small class="text-muted">Last Order:</small>
                                                                <div class="fw-bold">{{ \Carbon\Carbon::parse($item->last_order_date)->format('M d, Y') }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Performance Indicator -->
                                                <div class="text-center pt-2 border-top">
                                                    @php
                                                        $revenuePerOrder = $item->total_revenue / $item->total_orders;
                                                        $performanceLevel = $revenuePerOrder >= 10 ? 'high' : ($revenuePerOrder >= 5 ? 'medium' : 'low');
                                                        $performanceColor = $performanceLevel === 'high' ? 'success' : ($performanceLevel === 'medium' ? 'warning' : 'secondary');
                                                        $performanceText = $performanceLevel === 'high' ? 'High Performer' : ($performanceLevel === 'medium' ? 'Good Performer' : 'Standard');
                                                    @endphp
                                                    <span class="badge bg-{{ $performanceColor }} rounded-pill">
                                                        <i class="fas fa-star me-1"></i>{{ $performanceText }}
                                                    </span>
                                                    <div class="mt-1">
                                                        <small class="text-muted">{{ number_format($revenuePerOrder, 2) }} JD per order</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Enhanced Pagination -->
                            <div class="row mt-5">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            Showing {{ $finalOrders->firstItem() ?? 0 }} to {{ $finalOrders->lastItem() ?? 0 }} of {{ $finalOrders->total() }} items
                                        </div>
                                        <div>
                                            {{ $finalOrders->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Enhanced Empty State -->
                            <div class="text-center py-5">
                                <div class="bg-danger bg-opacity-10 rounded-circle p-4 d-inline-flex mb-4">
                                    <i class="fas fa-utensils text-danger" style="font-size: 3rem;"></i>
                                </div>
                                <h4 class="text-muted fw-bold mb-3">
                                    @if ($search || $filterName || $filterMinQuantity || $filterMaxQuantity || $filterStartDate || $filterEndDate)
                                        No cafeteria items found matching your filters
                                    @else
                                        No cafeteria items available
                                    @endif
                                </h4>
                                <p class="text-muted fs-5 mb-4">
                                    @if ($search || $filterName || $filterMinQuantity || $filterMaxQuantity || $filterStartDate || $filterEndDate)
                                        Try adjusting your search criteria or removing some filters.
                                    @else
                                        Cafeteria item statistics from completed gaming sessions will appear here.
                                    @endif
                                </p>
                                @if ($search || $filterName || $filterMinQuantity || $filterMaxQuantity || $filterStartDate || $filterEndDate)
                                    <button type="button" class="btn btn-outline-danger rounded-pill px-4"
                                        wire:click="clearFilters">
                                        <i class="fas fa-times me-2"></i>Clear All Filters
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            // Add any JavaScript functionality here if needed
            console.log('Cafeteria overview page loaded with modern UI');
        });
    </script>
@endpush