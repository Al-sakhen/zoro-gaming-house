@push('styles')
    <style>
        /* Modern Dashboard Styling */
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }

        .dashboard-container {
            background-image: url('/gaming-bg.svg');
            background-size: 100px 100px;
            background-repeat: repeat;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
        }

        .dashboard-container::before {
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

        /* Room Card Animations */
        .room-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 20px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .room-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .room-card.occupied {
            background: rgba(255, 245, 245, 0.95);
            border: 2px solid #ff6b6b;
        }

        .room-card.available {
            background: rgba(255, 251, 235, 0.95);
            border: 2px solid #ffd93d;
        }

        /* Modern Card Headers */
        .card-header.occupied {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
            min-height: auto;
            padding: 0.75rem 1rem;
        }

        .card-header.available {
            background: linear-gradient(135deg, #ffd93d 0%, #ff9500 100%);
            color: white;
            min-height: auto;
            padding: 0.75rem 1rem;
        }

        /* Compact Header Styling */
        .card-header h3 {
            font-size: 1rem;
            line-height: 1.2;
        }

        .card-header small {
            font-size: 0.75rem;
            line-height: 1.1;
        }

        /* Compact Badge Styling */
        .badge.small {
            font-size: 0.65rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
        }

        .badge-modern.small {
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        /* Modern Single Row Timer Styling */
        .timer-row {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .timer-display {
            color: #111827;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
            font-weight: 700;
            letter-spacing: -0.025em;
            background: #f8f9fa;
            border-radius: 12px;
            padding: 0.75rem 1.25rem;
            border: 1px solid #e9ecef;
            font-size: 1.75rem;
            margin: 0;
            min-width: fit-content;
        }

        .start-time-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            text-align: right;
            min-width: fit-content;
        }

        .start-time-label {
            font-size: 0.75rem;
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .start-time-value {
            font-size: 0.9rem;
            color: #111827;
            font-weight: 600;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
        }

        /* Fix icon centering */
        .icon-container {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* Session Info Box */
        .session-info {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 16px;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        /* Modern Buttons */
        .btn-modern {
            border-radius: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-modern:hover::before {
            left: 100%;
        }

        .btn-stop {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            border: none;
            color: white;
        }

        .btn-stop:hover {
            background: linear-gradient(135deg, #ee5a52 0%, #dc4444 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(238, 90, 82, 0.4);
        }

        .btn-start {
            background: linear-gradient(135deg, #ffd93d 0%, #ff9500 100%);
            border: none;
            color: white;
        }

        .btn-start:hover {
            background: linear-gradient(135deg, #ff9500 0%, #e8850a 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 149, 0, 0.4);
        }

        .btn-talabat {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }

        .btn-talabat:hover {
            background: linear-gradient(135deg, #764ba2 0%, #5a67d8 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(118, 75, 162, 0.4);
        }

        /* Badge Styling */
        .badge-modern {
            border-radius: 12px;
            font-weight: 600;
            padding: 0.5rem 1rem;
        }

        .badge-vip {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

        .badge-occupied {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        }

        .badge-available {
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
        }

        /* Gradient Background Helper */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* Modern Alerts */
        .alert-modern {
            border-radius: 16px;
            border: none;
            backdrop-filter: blur(10px);
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Price Display */
        .price-display {
            color: #667eea;
            font-weight: 700;
        }

        /* Empty State */
        .empty-state {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            padding: 3rem;
            text-align: center;
            border: 2px dashed rgba(102, 126, 234, 0.3);
        }

        /* Responsive Improvements */
        @media (max-width: 768px) {
            .room-card {
                margin-bottom: 1rem;
            }

            .btn-modern {
                font-size: 0.875rem;
                padding: 0.5rem 1rem;
            }

            .timer-display {
                font-size: 1.25rem;
            }
        }

        /* Loading Animation */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Search Container Styling */
        .search-container .input-group {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .search-container .input-group:focus-within {
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.3);
            transform: translateY(-2px);
        }

        .search-container .form-control {
            border: 2px solid #e9ecef;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            font-weight: 500;
        }

        .search-container .form-control:focus {
            border-color: #667eea;
            box-shadow: none;
            background: white;
        }

        .search-container .input-group-text {
            border: 2px solid #e9ecef;
            border-right: none;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .search-container .btn-outline-secondary {
            border: 2px solid #e9ecef;
            border-left: none;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .search-container .btn-outline-secondary:hover {
            background: #ff6b6b;
            border-color: #ff6b6b;
            color: white;
        }

        /* Status Filter Styling */
        .status-filter-container .btn-group {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-modern-filter {
            border-radius: 0 !important;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-modern-filter::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-modern-filter:hover::before {
            left: 100%;
        }

        .btn-modern-filter:first-child {
            border-top-left-radius: 16px !important;
            border-bottom-left-radius: 16px !important;
        }

        .btn-modern-filter:last-child {
            border-top-right-radius: 16px !important;
            border-bottom-right-radius: 16px !important;
        }

        .btn-modern-filter:hover {
            transform: translateY(-2px);
            z-index: 1;
        }

        /* Responsive adjustments for filter buttons */
        @media (max-width: 768px) {
            .btn-modern-filter {
                font-size: 0.75rem;
                padding: 0.6rem 0.8rem;
            }

            .status-filter-container {
                margin-top: 1rem;
            }
        }
    </style>
@endpush

<div class="dashboard-container">
    <div class="container-fluid fade-in" wire:poll.5s>
        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="alert alert-warning alert-dismissible fade show alert-modern mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle me-2 fs-5"></i>
                    <div>{{ session('message') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show alert-modern mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-triangle-exclamation me-2 fs-5"></i>
                    <div>{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Search Filter -->
        <div class="row mb-4">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="search-container">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0"
                            placeholder="Search rooms by name..." wire:model.live.debounce.300ms="search">
                        @if ($search)
                            <button class="btn btn-outline-secondary" type="button" wire:click="$set('search', '')"
                                title="Clear search">
                                <i class="fas fa-times"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Status Filter -->
            <div class="col-12 col-md-6 col-lg-4 mt-3 mt-md-0">
                <div class="status-filter-container">
                    <div class="btn-group w-100" role="group" aria-label="Room Status Filter">
                        <button type="button"
                            class="btn {{ $statusFilter === 'all' ? 'btn-primary' : 'btn-outline-primary' }} btn-modern-filter"
                            wire:click="setStatusFilter('all')">
                            <i class="fas fa-th-large me-1"></i>
                            All Rooms
                        </button>
                        <button type="button"
                            class="btn {{ $statusFilter === 'available' ? 'btn-success' : 'btn-outline-success' }} btn-modern-filter"
                            wire:click="setStatusFilter('available')">
                            <i class="fas fa-unlock me-1"></i>
                            Available
                        </button>
                        <button type="button"
                            class="btn {{ $statusFilter === 'occupied' ? 'btn-danger' : 'btn-outline-danger' }} btn-modern-filter"
                            wire:click="setStatusFilter('occupied')">
                            <i class="fas fa-lock me-1"></i>
                            Occupied
                        </button>
                    </div>
                </div>
            </div>

            @if ($search || $statusFilter !== 'all')
                <div class="col-12 mt-2">
                    <small class="text-muted">
                        <i class="fas fa-filter me-1"></i>
                        @if ($search && $statusFilter !== 'all')
                            Showing {{ $statusFilter }} rooms matching: <strong>"{{ $search }}"</strong>
                        @elseif($search)
                            Showing results for: <strong>"{{ $search }}"</strong>
                        @elseif($statusFilter !== 'all')
                            Showing {{ $statusFilter }} rooms only
                        @endif
                        <button class="btn btn-link btn-sm p-0 ms-2 text-decoration-none"
                            wire:click="$set('search', ''); $set('statusFilter', 'all')">
                            Clear all filters
                        </button>
                    </small>
                </div>
            @endif
        </div>

        <!-- Rooms Grid -->
        <div class="row g-4">
            @forelse($rooms as $room)
                @php
                    $activeSession = $room->activeSession();
                    $isOccupied = $room->isOccupied();
                @endphp

                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="card h-100 room-card shadow-lg {{ $isOccupied ? 'occupied' : 'available' }}">
                        <!-- Room Header -->
                        <div class="card-header {{ $isOccupied ? 'occupied' : 'available' }} position-relative py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <!-- Room Icon & Name -->
                                    <div class="me-2">
                                        @if($room->type === 'playstation')
                                            <i class="fab fa-playstation fs-5"></i>
                                        @elseif($room->type === 'pc')
                                            <i class="fas fa-desktop fs-5"></i>
                                        @else
                                            <i class="fas fa-table fs-5"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="h6 fw-bold mb-0">{{ $room->name }}</h3>
                                        <!-- Compact Price Display -->
                                        <small class="opacity-90">
                                            @if($room->type === 'tables')
                                                <span class="text-success fw-bold">Free</span>
                                            @elseif($room->type === 'playstation')
                                                @if($room->price_per_hour_2_controllers && $room->price_per_hour_4_controllers)
                                                    <span class="fw-semibold">2P: @currency($room->price_per_hour_2_controllers) <br> 4P: @currency($room->price_per_hour_4_controllers)</span>
                                                @else
                                                    <span class="fw-semibold">@currency($room->price_per_hour)/hr</span>
                                                @endif
                                            @else
                                                <span class="fw-semibold">@currency($room->price_per_hour)/hr</span>
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                
                                <!-- Status & Type Badges -->
                                <div class="d-flex flex-column align-items-end gap-1">
                                    <div class="d-flex align-items-center gap-1">
                                        <!-- Room Type Badge -->
                                        <span class="badge bg-secondary bg-opacity-75 text-white small px-2 py-1">
                                            {{ ucfirst($room->type) }}
                                        </span>
                                        
                                        @if ($room->is_vip)
                                            <span class="badge badge-modern badge-vip small px-2 py-1">
                                                <i class="fas fa-crown"></i>
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Status Badge -->
                                    <span class="badge badge-modern {{ $isOccupied ? 'badge-occupied' : 'badge-available' }} small px-2 py-1">
                                        <i class="fas {{ $isOccupied ? 'fa-lock' : 'fa-lock-open' }} me-1"></i>
                                        {{ $isOccupied ? 'BUSY' : 'FREE' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Session Info -->
                        <div class="card-body p-2">
                            @if ($isOccupied && $activeSession)
                                <div class="timer-row mb-2">
                                    <div class="timer-display" id="timer-{{ $room->id }}">
                                        {{ $this->getSessionDuration($activeSession) }}
                                    </div>
                                    <div class="start-time-info">
                                        <div class="start-time-label">Started</div>
                                        <div class="start-time-value">{{ $activeSession->started_at->format('g:i A') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="session-info p-2">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="text-center d-flex flex-column align-items-center">
                                                <div class="bg-primary bg-opacity-10 rounded-circle icon-container mb-1"
                                                    style="width: 32px; height: 32px;">
                                                    <i class="fas fa-gamepad text-primary"
                                                        style="font-size: 0.875rem;"></i>
                                                </div>
                                                <p class="small text-muted mb-0" style="font-size: 0.7rem;">Gaming</p>
                                                <p class="fw-bold mb-0 price-display" style="font-size: 0.8rem;">
                                                    {{ number_format($activeSession->calculateGamingPrice(), 2) }} JD
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-center d-flex flex-column align-items-center">
                                                <div class="bg-success bg-opacity-10 rounded-circle icon-container mb-1"
                                                    style="width: 32px; height: 32px;">
                                                    <i class="fas fa-utensils text-success"
                                                        style="font-size: 0.875rem;"></i>
                                                </div>
                                                <p class="small text-muted mb-0" style="font-size: 0.7rem;">Cafeteria
                                                </p>
                                                <p class="fw-bold mb-0 text-success" style="font-size: 0.8rem;">
                                                    {{ number_format($activeSession->calculateCafeteriaTotal(), 2) }}
                                                    JD
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-1">
                                    <div class="text-center">
                                        <div class="bg-gradient-primary rounded-pill py-1 px-2 d-inline-block">
                                            <span class="text-white fw-bold" style="font-size: 0.75rem;">
                                                <i class="fas fa-receipt me-1"></i>
                                                Total: {{ number_format($activeSession->calculateGrandTotal(), 2) }} JD
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cafeteria Orders Section -->
                                @php
                                    $orders = $activeSession->orders;
                                    $cafeteriaTotal = $activeSession->calculateCafeteriaTotal();
                                @endphp
                                @if ($orders->count() > 0)
                                    <div class="px-2 pb-1">
                                        <div class="accordion accordion-flush"
                                            id="accordion-room-{{ $room->id }}">
                                            <div class="accordion-item border-0">
                                                <h6 class="accordion-header mb-0">
                                                    <button class="accordion-button collapsed p-2 rounded"
                                                        style="background: #f8f9fa; font-size: 0.75rem; border: 1px solid #e9ecef;"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapse-room-{{ $room->id }}"
                                                        aria-expanded="false">
                                                        <small class="text-muted fw-bold">
                                                            <i class="fas fa-utensils me-2"></i>
                                                            {{ $orders->count() }} Cafeteria Items
                                                            <span
                                                                class="ms-2 text-success">{{ number_format($cafeteriaTotal, 2) }}
                                                                JD</span>
                                                        </small>
                                                    </button>
                                                </h6>
                                                <div id="collapse-room-{{ $room->id }}"
                                                    class="accordion-collapse collapse"
                                                    data-bs-parent="#accordion-room-{{ $room->id }}">
                                                    <div class="accordion-body p-2 pt-0">
                                                        <div class="bg-white border rounded p-2">
                                                            @foreach ($orders as $order)
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center py-1 {{ !$loop->last ? 'border-bottom' : '' }}">
                                                                    <div class="d-flex align-items-center flex-grow-1">
                                                                        <span class="badge bg-primary me-2"
                                                                            style="font-size: 0.6rem;">
                                                                            {{ $order->units_count }}x
                                                                        </span>
                                                                        <small
                                                                            class="fw-semibold text-truncate">{{ $order->cafeteriaItem->name }}</small>
                                                                    </div>
                                                                    <div class="text-end ms-2">
                                                                        <div class="fw-bold text-success small">
                                                                            {{ number_format($order->total_price, 2) }}
                                                                            JD
                                                                        </div>
                                                                        <div class="text-muted"
                                                                            style="font-size: 0.65rem;">
                                                                            {{ number_format($order->price_per_unit, 2) }}
                                                                            JD/unit
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div
                                    class="text-center py-3 d-flex flex-column align-items-center  h-100 justify-content-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle icon-container mb-2"
                                        style="width: 64px; height: 64px; display: inline-flex;">
                                        <i class="fas fa-gamepad text-primary" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <h6 class="fw-bold text-primary mb-1">Ready to Game</h6>
                                    <p class="text-muted small mb-0">Room is available and waiting for players</p>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="card-footer bg-transparent border-0 p-2">
                            @if ($isOccupied)
                                <div class="row g-2">
                                    <div class="col-6">
                                        <button wire:click="stopSession({{ $room->id }})"
                                            class="btn btn-stop btn-modern w-100 py-2 position-relative">
                                            <i class="fas fa-stop me-2"></i>
                                            <span>Stop</span>
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button wire:click="openOrderDialog({{ $activeSession->id }})"
                                            class="btn btn-talabat btn-modern w-100 py-2 position-relative">
                                            <i class="fas fa-utensils me-2"></i>
                                            <span >Talabat</span>
                                        </button>
                                    </div>
                                </div>
                            @else
                                <button wire:click="startSession({{ $room->id }})"
                                    class="btn btn-start btn-modern w-100 py-2 position-relative">
                                    <i class="fas fa-play me-2"></i>
                                    <span>Start</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state fade-in">
                        @if ($search || $statusFilter !== 'all')
                            <!-- No Search/Filter Results -->
                            <div class="bg-warning bg-opacity-10 rounded-circle p-4 d-inline-flex mb-4">
                                <i class="fas fa-filter display-2 text-warning"></i>
                            </div>
                            <h3 class="h4 fw-bold text-warning mb-3">No Rooms Found</h3>
                            <p class="text-muted fs-5 mb-4">
                                @if ($search && $statusFilter !== 'all')
                                    No {{ $statusFilter }} rooms match your search
                                    "<strong>{{ $search }}</strong>".
                                @elseif($search)
                                    No rooms match your search term "<strong>{{ $search }}</strong>".
                                @else
                                    No {{ $statusFilter }} rooms available.
                                @endif
                                <br>Try adjusting your filters or clear them to see all rooms.
                            </p>
                            <div class="d-flex justify-content-center gap-2">
                                @if ($search)
                                    <button class="btn btn-warning btn-modern px-4 py-2"
                                        wire:click="$set('search', '')">
                                        <i class="fas fa-times me-2"></i>Clear Search
                                    </button>
                                @endif
                                @if ($statusFilter !== 'all')
                                    <button class="btn btn-info btn-modern px-4 py-2"
                                        wire:click="setStatusFilter('all')">
                                        <i class="fas fa-th-large me-2"></i>Show All
                                    </button>
                                @endif
                                @if ($search || $statusFilter !== 'all')
                                    <button class="btn btn-secondary btn-modern px-4 py-2"
                                        wire:click="$set('search', ''); setStatusFilter('all')">
                                        <i class="fas fa-refresh me-2"></i>Reset Filters
                                    </button>
                                @endif
                            </div>
                        @else
                            <!-- No Rooms at All -->
                            <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-flex mb-4">
                                <i class="fas fa-building display-2 text-primary"></i>
                            </div>
                            <h3 class="h4 fw-bold text-primary mb-3">No Rooms Available</h3>
                            <p class="text-muted fs-5 mb-4">Create some rooms first to start managing your gaming
                                center.</p>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary btn-modern px-4 py-2">
                                    <i class="fas fa-plus me-2"></i>Add New Room
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        {{-- <!-- Order Dialog -->
    @if ($showOrderDialog && $selectedSession)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <livewire:order-dialog :session="$selectedSession" wire:key="order-{{ $selectedSession->id }}"
                            @closeDialog="closeOrderDialog" />
                    </div>
                </div>
            </div>
        </div>
    @endif --}}




        {{-- Removed Order Modal - Now using separate page --}}

        {{-- Controller Selection Dialog for PlayStation Rooms --}}
        @if ($showControllerDialog && $selectedRoom)
            <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-gamepad me-2"></i>
                                Select Controllers for {{ $selectedRoom->name }}
                            </h5>
                            <button type="button" class="btn-close" wire:click="closeControllerDialog"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center mb-4">
                                <p class="mb-4">How many controllers will be used for this PlayStation session?</p>
                                
                                <div class="row g-3">
                                    <div class="col-6">
                                        <button wire:click="startSessionWithControllers(2)" 
                                                class="btn btn-primary btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                                                style="min-height: 120px;">
                                            <i class="fas fa-gamepad fa-2x mb-2"></i>
                                            <strong>2 Controllers</strong>
                                            @if($selectedRoom->price_per_hour_2_controllers)
                                                <small class="mt-1">${{ number_format($selectedRoom->price_per_hour_2_controllers, 2) }}/hour</small>
                                            @endif
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button wire:click="startSessionWithControllers(4)" 
                                                class="btn btn-success btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                                                style="min-height: 120px;">
                                            <i class="fas fa-gamepad fa-2x mb-2"></i>
                                            <i class="fas fa-gamepad fa-2x mb-2" style="margin-left: -10px;"></i>
                                            <strong>4 Controllers</strong>
                                            @if($selectedRoom->price_per_hour_4_controllers)
                                                <small class="mt-1">${{ number_format($selectedRoom->price_per_hour_4_controllers, 2) }}/hour</small>
                                            @endif
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeControllerDialog">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
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

            // ============== Open Talabat in New Window ==============
            Livewire.on('openTalabatWindow', (event) => {
                const url = event[0];
                const talabatWindow = window.open(
                    url,
                    'talabat_window',
                    'width=1200,height=800,scrollbars=yes,resizable=yes,toolbar=no,menubar=no,location=no,status=no'
                );

                // Focus the new window
                if (talabatWindow) {
                    talabatWindow.focus();

                    // Optional: Listen for window close to refresh dashboard
                    const checkClosed = setInterval(() => {
                        if (talabatWindow.closed) {
                            clearInterval(checkClosed);
                            // Refresh the dashboard component to update totals
                            Livewire.dispatch('refreshComponent');
                        }
                    }, 1000);
                }
            });

            // ============== Open Session Summary in New Window ==============
            Livewire.on('openSessionSummaryWindow', (event) => {
                const url = event[0];
                const sessionWindow = window.open(
                    url,
                    'session_summary_window',
                    'width=1200,height=900,scrollbars=yes,resizable=yes,toolbar=no,menubar=no,location=no,status=no'
                );

                // Focus the new window
                if (sessionWindow) {
                    sessionWindow.focus();

                    // Enhanced window close detection with session status check
                    let sessionEnded = false;
                    
                    // Listen for messages from the popup
                    const messageHandler = (event) => {
                        if (event.data && event.data.type === 'sessionStatus') {
                            sessionEnded = event.data.sessionEnded;
                        }
                    };
                    window.addEventListener('message', messageHandler);

                    // Check if window is closed and handle session cancellation
                    const checkClosed = setInterval(() => {
                        if (sessionWindow.closed) {
                            clearInterval(checkClosed);
                            window.removeEventListener('message', messageHandler);
                            
                            // If session wasn't properly ended, it was cancelled by closing
                            if (!sessionEnded) {
                                console.log('Session summary popup was closed without confirmation - session should be resumed');
                            }
                            
                            // Always refresh the dashboard component to update room status
                            Livewire.dispatch('refreshComponent');
                        } else {
                            // Periodically check session status
                            try {
                                sessionWindow.postMessage('checkSessionStatus', '*');
                            } catch (e) {
                                // Window might be closing or from different origin
                            }
                        }
                    }, 1000);
                }
            });
        });
    </script>


    <script>
        // Update timers every second for active sessions
        setInterval(function() {
            @if ($rooms->where('status', 'occupied')->count() > 0)
                @foreach ($rooms->where('status', 'occupied') as $room)
                    @if ($room->activeSession())
                        updateTimer({{ $room->id }},
                            '{{ $room->activeSession()->started_at->toISOString() }}');
                    @endif
                @endforeach
            @endif
        }, 1000);

        function updateTimer(roomId, startTime) {
            const startDate = new Date(startTime);
            const now = new Date();
            const diff = now - startDate;

            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            const timerElement = document.getElementById(`timer-${roomId}`);
            if (timerElement) {
                timerElement.textContent =
                    `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }
        }
    </script>
@endpush
