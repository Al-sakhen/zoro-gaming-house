@push('styles')
    <style>
        /* Modern Sessions Page Styling */
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }

        .sessions-container {
            background-image: url('/gaming-bg.svg');
            background-size: 100px 100px;
            background-repeat: repeat;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
        }

        .sessions-container::before {
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

        /* Session Cards */
        .session-card {
            border-radius: 16px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            height: 100%;
        }

        .session-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .session-card.active {
            background: rgba(255, 251, 235, 0.95);
            border: 2px solid #4caf50;
        }

        .session-card.completed {
            background: rgba(248, 249, 250, 0.95);
            border: 2px solid #6c757d;
        }

        .session-header {
            padding: 1rem;
            position: relative;
            overflow: hidden;
        }

        .session-header.active {
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
            color: white;
        }

        .session-header.completed {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            color: white;
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
            border: 2px solid rgba(102, 126, 234, 0.2);
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .modern-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            outline: none;
        }

        /* Badges */
        .modern-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .badge-vip {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            animation: pulse-glow 2s infinite;
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 5px rgba(102, 126, 234, 0.5);
            }

            50% {
                box-shadow: 0 0 20px rgba(102, 126, 234, 0.8);
            }
        }

        /* Discount & Adjustment Badges */
        .badge.bg-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
            border: none;
            font-size: 0.75rem;
            animation: subtle-pulse 3s infinite;
        }

        .badge.bg-warning {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%) !important;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
            border: none;
            font-size: 0.75rem;
            animation: subtle-pulse 3s infinite;
        }

        @keyframes subtle-pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            }
            50% {
                transform: scale(1.02);
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            }
        }

        /* Price Display */
        .price-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 16px;
            padding: 1rem;
            margin: 1rem 0;
        }

        .price-item {
            text-align: center;
            padding: 0.5rem;
        }

        .price-value {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .price-label {
            font-size: 0.75rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Sort Buttons */
        .sort-btn {
            background: rgba(102, 126, 234, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.3);
            color: #667eea;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }

        .sort-btn:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .sort-btn.active {
            background: #667eea;
            color: white;
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

        /* Compact Accordion Styling */
        .accordion-button {
            font-size: 0.875rem;
            padding: 0.5rem;
            background: #f8f9fa;
            border-radius: 8px !important;
        }

        .accordion-button:not(.collapsed) {
            background: #e9ecef;
            box-shadow: none;
        }

        .accordion-button::after {
            font-size: 0.7rem;
        }

        .accordion-body {
            background: rgba(248, 249, 250, 0.5);
        }

        .accordion-item {
            background: transparent;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .modern-header {
                padding: 1rem;
            }

            .filters-section {
                padding: 1rem;
            }

            .session-header {
                padding: 0.75rem;
            }

            .stat-card {
                margin-bottom: 1rem;
            }
        }
    </style>
@endpush

<div class="sessions-container">
    <div class="container-fluid py-4 fade-in">
        <div class="row">
            <div class="col-12">
                <div class="card modern-card">
                    <div class="card-header modern-header bg-primary">
                        <h3 class="card-title mb-0 d-flex align-items-center text-white">
                            <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <span>Gaming Sessions Management</span>
                        </h3>
                        <div class="mt-2">
                            <span class="badge badge-success bg-opacity-20 text-white px-3 py-2 rounded-pill">
                                {{ $sessions->total() }} Total Sessions
                            </span>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="card-body p-3">
                        <div class="row g-3 mb-3">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-icon bg-info">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold text-primary">
                                            {{ number_format($stats['total_sessions']) }}</h5>
                                        <small class="text-muted fw-600">Total Sessions</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-icon bg-success">
                                        <i class="fas fa-play"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold text-success">
                                            {{ number_format($stats['active_sessions']) }}</h5>
                                        <small class="text-muted fw-600">Active Sessions</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-icon bg-warning">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold text-warning">
                                            {{ number_format($stats['completed_sessions']) }}</h5>
                                        <small class="text-muted fw-600">Completed</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-icon bg-primary">
                                        <i class="fas fa-clock-o"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold text-primary">
                                            {{ $stats['average_duration'] }}</h5>
                                        <small class="text-muted fw-600">Average Duration</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filters Section -->
                        <div class="filters-section">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-filter text-primary"></i>
                                </div>
                                <h5 class="text-primary mb-0 fw-bold">Filters & Search</h5>
                            </div>

                            <!-- Sort Options -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold text-muted">Sort By:</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button class="sort-btn {{ $sortField === 'created_at' ? 'active' : '' }}"
                                            wire:click="sortBy('created_at', '{{ $sortField === 'created_at' && $sortDirection === 'desc' ? 'asc' : 'desc' }}')">
                                            <i class="fas fa-calendar me-1"></i>Date
                                            @if ($sortField === 'created_at')
                                                <i
                                                    class="fas fa-sort-{{ $sortDirection === 'desc' ? 'down' : 'up' }} ms-1"></i>
                                            @endif
                                        </button>
                                        <button class="sort-btn {{ $sortField === 'room_name' ? 'active' : '' }}"
                                            wire:click="sortBy('room_name', '{{ $sortField === 'room_name' && $sortDirection === 'asc' ? 'desc' : 'asc' }}')">
                                            <i class="fas fa-door-open me-1"></i>Room
                                            @if ($sortField === 'room_name')
                                                <i
                                                    class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                            @endif
                                        </button>
                                        <button class="sort-btn {{ $sortField === 'final_total' ? 'active' : '' }}"
                                            wire:click="sortBy('final_total', '{{ $sortField === 'final_total' && $sortDirection === 'desc' ? 'asc' : 'desc' }}')">
                                            <i class="fas fa-money-bill me-1"></i>Revenue
                                            @if ($sortField === 'final_total')
                                                <i
                                                    class="fas fa-sort-{{ $sortDirection === 'desc' ? 'down' : 'up' }} ms-1"></i>
                                            @endif
                                        </button>
                                        <button class="sort-btn {{ $sortField === 'started_at' ? 'active' : '' }}"
                                            wire:click="sortBy('started_at', '{{ $sortField === 'started_at' && $sortDirection === 'desc' ? 'asc' : 'desc' }}')">
                                            <i class="fas fa-clock me-1"></i>Duration
                                            @if ($sortField === 'started_at')
                                                <i
                                                    class="fas fa-sort-{{ $sortDirection === 'desc' ? 'down' : 'up' }} ms-1"></i>
                                            @endif
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-lg-3 col-md-6">
                                    <label for="search" class="form-label fw-bold">
                                        <i class="fas fa-search me-1"></i>Search by Room Name
                                    </label>
                                    <input type="text" class="form-control modern-input" id="search"
                                        wire:model.live.debounce.300ms="search" placeholder="Enter room name...">
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <label for="filterStatus" class="form-label fw-bold">
                                        <i class="fas fa-filter me-1"></i>Status
                                    </label>
                                    <select class="form-control modern-input" id="filterStatus"
                                        wire:model.live="filterStatus">
                                        <option value="all">All Sessions</option>
                                        <option value="active">Active Sessions</option>
                                        <option value="completed">Completed Sessions</option>
                                    </select>
                                </div>
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
                                <div class="col-lg-1 col-md-6">
                                    <label class="form-label fw-bold">&nbsp;</label>
                                    <button type="button" class="btn btn-outline-danger w-100 rounded-pill"
                                        wire:click="clearFilters" title="Clear All Filters">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Filter Summary -->
                            @if ($search || $filterStatus !== 'all' || $filterStartDate || $filterEndDate || $filterStartTime || $filterEndTime)
                                <div class="mt-4">
                                    <div class="alert alert-info border-0 rounded-4"
                                        style="background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-filter me-2 text-info"></i>
                                            <strong class="text-info">Active Filters:</strong>
                                        </div>
                                        <div class="mt-2">
                                            @if ($search)
                                                <span class="modern-badge bg-primary text-white me-2 mb-1">Room:
                                                    {{ $search }}</span>
                                            @endif
                                            @if ($filterStatus !== 'all')
                                                <span class="modern-badge bg-success text-white me-2 mb-1">Status:
                                                    {{ ucfirst($filterStatus) }}</span>
                                            @endif
                                            @if ($filterStartDate)
                                                <span class="modern-badge bg-warning text-dark me-2 mb-1">From:
                                                    {{ $filterStartDate }}{{ $filterStartTime ? ' ' . $filterStartTime : '' }}</span>
                                            @endif
                                            @if ($filterEndDate)
                                                <span class="modern-badge bg-warning text-dark me-2 mb-1">To:
                                                    {{ $filterEndDate }}{{ $filterEndTime ? ' ' . $filterEndTime : '' }}</span>
                                            @endif
                                            @if ($filterStartTime && !$filterStartDate)
                                                <span class="modern-badge bg-info text-white me-2 mb-1">After:
                                                    {{ $filterStartTime }}</span>
                                            @endif
                                            @if ($filterEndTime && !$filterEndDate)
                                                <span class="modern-badge bg-info text-white me-2 mb-1">Before:
                                                    {{ $filterEndTime }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Sessions Grid -->
                        @if ($sessions->count() > 0)
                            <div class="row g-4">
                                @foreach ($sessions as $session)
                                    @php
                                        $isActive = $session->is_active;
                                        $hasAdjustment =
                                            $session->gaming_price_adjustment && $session->gaming_price_adjustment != 0;
                                        $hasDiscount = $session->discount_amount && $session->discount_amount > 0;
                                        $originalGamingPrice = $session->calculateGamingPrice();
                                        $finalGamingPrice = $session->adjusted_gaming_price ?? $originalGamingPrice;
                                        $cafeteriaTotal = $session->calculateCafeteriaTotal();
                                        $finalTotal = $session->final_total ?? $session->calculateGrandTotal();
                                    @endphp

                                    <div class="col-lg-3 col-md-6">
                                        <div class="session-card {{ $isActive ? 'active' : 'completed' }}">
                                            <!-- Session Header -->
                                            <div class="session-header {{ $isActive ? 'active' : 'completed' }}">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h5 class="mb-1 fw-bold d-flex align-items-center">
                                                            <i class="fas fa-door-open me-2"></i>
                                                            {{ $session->room->name }}
                                                        </h5>
                                                        <p class="small mb-0 opacity-90">
                                                            <i class="fas fa-calendar me-1"></i>
                                                            Session #{{ $session->id }}
                                                        </p>
                                                    </div>
                                                    <div class="d-flex flex-column align-items-end">
                                                        @if ($session->room->is_vip)
                                                            <span class="badge badge-vip mb-2">
                                                                <i class="fas fa-crown me-1"></i>VIP
                                                            </span>
                                                        @endif

                                                        <span
                                                            class="modern-badge {{ $isActive ? 'bg-light text-success' : 'bg-light text-secondary' }}">
                                                            <i
                                                                class="fas {{ $isActive ? 'fa-play' : 'fa-check' }} me-1"></i>
                                                            {{ $isActive ? 'ACTIVE' : 'COMPLETED' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Card Body -->
                                            <div class="card-body p-2">
                                                <!-- Compact Session Info -->
                                                <div class="row g-2 mb-2">
                                                    <div class="col-4">
                                                        <div class="text-center p-1">
                                                            <div class="price-label mb-0">Started</div>
                                                            <div class="fw-bold small">
                                                                {{ $session->started_at->format('M j') }}</div>
                                                            <div class="text-muted" style="font-size: 0.7rem;">
                                                                {{ $session->started_at->format('H:i') }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="text-center p-1">
                                                            <div class="price-label mb-0">Duration</div>
                                                            <div class="fw-bold small text-primary">
                                                                {{ $session->getFormattedDuration() }}
                                                            </div>
                                                            <div class="text-muted" style="font-size: 0.7rem;">
                                                                {{ $session->getDurationInMinutes() }} min total</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="text-center p-1">
                                                            <div class="price-label mb-0">
                                                                {{ $isActive ? 'Active' : 'Ended' }}</div>
                                                            <div class="fw-bold small">
                                                                @if ($isActive)
                                                                    <span class="text-success">Live</span>
                                                                @else
                                                                    {{ $session->ended_at ? $session->ended_at->format('M j') : '-' }}
                                                                @endif
                                                            </div>
                                                            <div class="text-muted" style="font-size: 0.7rem;">
                                                                @if ($isActive)
                                                                    Now
                                                                @else
                                                                    {{ $session->ended_at ? $session->ended_at->format('H:i') : '-' }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Compact Pricing -->
                                                <div
                                                    class="d-flex justify-content-between align-items-center p-2 bg-light rounded mb-2">
                                                    <div class="text-center flex-fill">
                                                        <div class="fw-bold text-primary">
                                                            {{ number_format($finalGamingPrice, 2) }} JD</div>
                                                        <small class="text-muted">Gaming @if ($hasAdjustment)
                                                                <span class="badge bg-info ms-1"
                                                                    style="font-size: 0.5rem;">+{{ number_format($session->gaming_price_adjustment, 2) }}</span>
                                                            @endif
                                                        </small>
                                                    </div>
                                                    <div class="text-center flex-fill">
                                                        <div class="fw-bold text-success">
                                                            {{ number_format($cafeteriaTotal, 2) }} JD</div>
                                                        <small class="text-muted">Cafeteria</small>
                                                    </div>
                                                    <div class="text-center flex-fill">
                                                        <div class="fw-bold text-dark h6 mb-0">
                                                            {{ number_format($finalTotal, 2) }} JD</div>
                                                        <small class="text-muted">Total</small>
                                                    </div>


                                                </div>

                                                <!-- Discount & Adjustment Indicators -->
                                                @if ($hasDiscount || $hasAdjustment)
                                                    <div class="d-flex justify-content-center gap-2 mb-2">
                                                        @if ($hasDiscount)
                                                            <div class="badge bg-danger text-white px-3 py-2 rounded-pill d-flex align-items-center">
                                                                <i class="fas fa-percentage me-1"></i>
                                                                <span class="fw-bold">
                                                                    -{{ number_format($session->discount_amount, 2) }} JD Discount
                                                                </span>
                                                                @if ($session->discount_percentage > 0)
                                                                    <small class="ms-1 opacity-75">
                                                                        ({{ number_format($session->discount_percentage, 1) }}%)
                                                                    </small>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        
                                                        @if ($hasAdjustment)
                                                            <div class="badge bg-warning text-dark px-3 py-2 rounded-pill d-flex align-items-center">
                                                                <i class="fas fa-arrow-up me-1"></i>
                                                                <span class="fw-bold">
                                                                    +{{ number_format($session->gaming_price_adjustment, 2) }} JD Gaming Increase
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif

                                                <div>
                                                    <!-- Cafeteria Items Section -->
                                                    @php
                                                        $orders = $isActive ? $session->orders : $session->finalOrders;
                                                    @endphp
                                                    @if ($orders->count() > 0)
                                                        <div class="row mt-2">
                                                            <div class="col-12">
                                                                <div class="accordion accordion-flush"
                                                                    id="accordion-{{ $session->id }}">
                                                                    <div class="accordion-item border-0">
                                                                        <h6 class="accordion-header mb-0">
                                                                            <button
                                                                                class="accordion-button collapsed p-2  rounded"
                                                                                style="background: #f1f3f5; font-size: 0.875rem; border:1px solid #dee2e6;"
                                                                                type="button"
                                                                                data-bs-toggle="collapse"
                                                                                data-bs-target="#collapse-{{ $session->id }}"
                                                                                aria-expanded="false">
                                                                                <small class="text-muted fw-bold">
                                                                                    <i
                                                                                        class="fas fa-utensils me-2"></i>
                                                                                    {{ $orders->count() }} Cafeteria
                                                                                    Items
                                                                                    <span
                                                                                        class="ms-2 text-success">{{ number_format($cafeteriaTotal, 2) }}
                                                                                        JD</span>
                                                                                </small>
                                                                            </button>
                                                                        </h6>
                                                                        <div id="collapse-{{ $session->id }}"
                                                                            class="accordion-collapse collapse"
                                                                            data-bs-parent="#accordion-{{ $session->id }}">
                                                                            <div class="accordion-body p-2 pt-0">
                                                                                <div
                                                                                    class="bg-white border rounded p-2">
                                                                                    @foreach ($orders as $order)
                                                                                        <div
                                                                                            class="d-flex justify-content-between align-items-center py-1 {{ !$loop->last ? 'border-bottom' : '' }}">
                                                                                            <div
                                                                                                class="d-flex align-items-center flex-grow-1">
                                                                                                <span
                                                                                                    class="badge bg-primary me-2"
                                                                                                    style="font-size: 0.6rem;">
                                                                                                    {{ $order->units_count }}x
                                                                                                </span>
                                                                                                <small
                                                                                                    class="fw-semibold text-truncate">{{ $order->cafeteriaItem->name }}</small>
                                                                                            </div>
                                                                                            <div class="text-end ms-2">
                                                                                                <div
                                                                                                    class="fw-bold text-success small">
                                                                                                    {{ number_format($order->total_price, 2) }}
                                                                                                    JD</div>
                                                                                                <div class="text-muted"
                                                                                                    style="font-size: 0.65rem;">
                                                                                                    {{ number_format($order->price_per_unit, 2) }}
                                                                                                    JD/unit</div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="text-center py-2">
                                                            <small class="text-muted">
                                                                <i class="fas fa-info-circle me-1"></i>No cafeteria
                                                                items
                                                                ordered.
                                                            </small>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Footer -->
                                                <div class="card-footer bg-transparent border-0 p-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="text-muted small">
                                                            <i class="fas fa-clock me-1"></i>
                                                            {{ $session->created_at->diffForHumans() }}
                                                        </div>
                                                        <div class="text-muted small">
                                                            <i class="fas fa-hashtag me-1"></i>
                                                            ID: {{ $session->id }}
                                                        </div>
                                                    </div>

                                                    <!-- Performance Indicator -->
                                                    @php
                                                        $durationHours = $session->getDurationInHours();
                                                        $revenuePerHour =
                                                            $durationHours > 0 ? $finalTotal / $durationHours : 0;
                                                    @endphp
                                                    @if (!$isActive && $revenuePerHour > 0)
                                                        <div class="text-center mt-3 pt-3 border-top">
                                                            <small class="text-muted">
                                                                <i class="fas fa-chart-line me-1"></i>
                                                                Performance:
                                                                <strong>{{ number_format($revenuePerHour, 2) }}
                                                                    JD/hour</strong>
                                                            </small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Enhanced Pagination -->
                            <div class="row mt-5">
                                <div class="col-12">
                                    <div class="d-flex justify-content-center">
                                        {{ $sessions->links() }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Enhanced Empty State -->
                            <div class="text-center py-5">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-flex mb-4">
                                    @if ($search || $filterStatus !== 'all' || $filterStartDate || $filterEndDate)
                                        <i class="fas fa-search display-2 text-warning"></i>
                                    @else
                                        <i class="fas fa-clock display-2 text-primary"></i>
                                    @endif
                                </div>
                                <h4 class="text-muted fw-bold mb-3">
                                    @if ($search || $filterStatus !== 'all' || $filterStartDate || $filterEndDate)
                                        No Sessions Match Your Filters
                                    @else
                                        No Sessions Created Yet
                                    @endif
                                </h4>
                                <p class="text-muted fs-5 mb-4">
                                    @if ($search || $filterStatus !== 'all' || $filterStartDate || $filterEndDate)
                                        Try adjusting your search terms or filters to see more results.
                                    @else
                                        Gaming sessions will appear here once customers start using the rooms.
                                    @endif
                                </p>
                                @if ($search || $filterStatus !== 'all' || $filterStartDate || $filterEndDate)
                                    <button class="btn btn-outline-primary rounded-pill px-4 py-2"
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
            console.log('Sessions page loaded with modern UI');
        });
    </script>
@endpush
