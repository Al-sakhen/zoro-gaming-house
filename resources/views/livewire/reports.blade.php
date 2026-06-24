@push('styles')
    @vite('resources/css/reports.css')
@endpush

<div>
    <div class="reports-container">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <!-- Header -->
                    <div class="glass-card p-5 mb-4 slide-in">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="header-icon me-4">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <div>
                                        <h1 class="text-white fw-bold mb-1" style="font-size: 2.5rem;">
                                            Gaming Center Analytics
                                        </h1>
                                        <h4 class="text-white mb-0" style="font-weight: 400; opacity: 0.9;">
                                            Advanced Business Intelligence Dashboard
                                        </h4>
                                    </div>
                                </div>
                                <p class="text-white-50 mb-0 fs-5">
                                    <i class="fas fa-lightbulb me-2"></i>
                                    Comprehensive insights to optimize your gaming center performance
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="update-info p-3 rounded-4">
                                    <div class="d-flex align-items-center justify-content-end mb-2">
                                        <i class="fas fa-sync-alt text-success me-2"></i>
                                        <span class="text-white fw-bold">Live Data</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-end">
                                        <i class="fas fa-clock text-white-50 me-2"></i>
                                        <span class="text-white-50">
                                            {{ now()->format('M j, Y • H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Date Range Filters -->
                    <div class="glass-card p-4 mb-4 slide-in">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-2">
                                <label class="form-label text-white fw-bold">
                                    <i class="fas fa-clock me-1"></i>Quick Select
                                </label>
                                <select class="form-select form-control-glass" wire:model.live="selectedPeriod">
                                    <option value="today">Today</option>
                                    <option value="yesterday">Yesterday</option>
                                    <option value="week">This Week</option>
                                    <option value="month">This Month</option>
                                    <option value="last_month">Last Month</option>
                                    <option value="custom">Custom Range</option>
                                </select>
                            </div>

                            @if ($selectedPeriod === 'custom')
                                <div class="col-md-2">
                                    <label class="form-label text-white fw-bold">From Date</label>
                                    <input type="date" class="form-control form-control-glass"
                                        wire:model="startDate">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label text-white fw-bold">To Date</label>
                                    <input type="date" class="form-control form-control-glass" wire:model="endDate">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label text-white fw-bold">From Time</label>
                                    <input type="time" class="form-control form-control-glass"
                                        wire:model="startTime">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label text-white fw-bold">To Time</label>
                                    <input type="time" class="form-control form-control-glass" wire:model="endTime">
                                </div>
                            @endif

                            <div class="col-md-2">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-glass flex-fill" wire:click="generateReport">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Generate Report
                                    </button>
                                    @if ($reportGenerated)
                                        <button type="button" class="btn btn-outline-light" wire:click="clearFilters"
                                            title="Clear">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($reportGenerated)
                        <!-- Key Performance Indicators -->
                        <div class="row g-4 mb-4">
                            <div class="col-lg-3 col-md-6">
                                <div class="stat-card-report slide-in">
                                    <div class="stat-icon-report bg-success">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <h3 class="text-white fw-bold mb-1">{{ number_format($totalRevenue, 2) }} JD</h3>
                                    <p class="text-white-50 mb-0">Total Revenue</p>
                                    <small class="text-success">
                                        <i class="fas fa-arrow-up me-1"></i>
                                        Primary Income
                                    </small>
                                    <div class="mt-2">
                                        <small class="text-info">
                                            <i class="fas fa-gamepad me-1"></i>
                                            Playing Revenue: {{ number_format($totalPlayingRevenue, 2) }} JD
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="stat-card-report slide-in">
                                    <div class="stat-icon-report bg-primary">
                                        <i class="fas fa-gamepad"></i>
                                    </div>
                                    <h3 class="text-white fw-bold mb-1">{{ number_format($totalSessions) }}</h3>
                                    <p class="text-white-50 mb-0">Total Sessions</p>
                                    <small class="text-primary">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ number_format($totalGamingHours, 1) }}h played
                                    </small>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="stat-card-report slide-in">
                                    <div class="stat-icon-report bg-warning">
                                        <i class="fas fa-utensils"></i>
                                    </div>
                                    <h3 class="text-white fw-bold mb-1">{{ number_format($totalCafeteriaRevenue, 2) }}
                                        JD
                                    </h3>
                                    <p class="text-white-50 mb-0">Cafeteria Revenue</p>
                                    <small class="text-warning">
                                        <i class="fas fa-percentage me-1"></i>
                                        {{ $totalRevenue > 0 ? number_format(($totalCafeteriaRevenue / $totalRevenue) * 100, 1) : 0 }}%
                                        of total
                                    </small>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="stat-card-report slide-in">
                                    <div class="stat-icon-report bg-info">
                                        <i class="fas fa-coins"></i>
                                    </div>
                                    <h3 class="text-white fw-bold mb-1">{{ number_format($totalActualRevenue, 2) }}
                                        JD
                                    </h3>
                                    <p class="text-white-50 mb-0">Actual Revenue</p>
                                    <small class="text-info">
                                        <i class="fas fa-receipt me-1"></i>
                                        Sales {{ number_format($totalCafeteriaRevenue, 2) }} JD - Cost {{ number_format($totalCafeteriaCost, 2) }} JD
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <!-- Room Performance -->
                            <div class="col-lg-6">
                                <div class="glass-card p-4 h-100 slide-in">
                                    <h5 class="text-white fw-bold mb-4 d-flex align-items-center">
                                        <i class="fas fa-door-open text-info me-2"></i>
                                        Room Performance (Most Used)
                                    </h5>
                                    @if (count($roomStats) > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover glass-table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-white">Room</th>
                                                        <th class="text-white">Hours</th>
                                                        <th class="text-white">Sessions</th>
                                                        <th class="text-white">Revenue</th>
                                                        <th class="text-white">Pricing Details</th>
                                                        <th class="text-white">Utilization</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($roomStats as $stat)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    @if ($stat->room->is_vip)
                                                                        <span class="badge bg-warning me-2">VIP</span>
                                                                    @endif
                                                                    <strong class="text-white">{{ $stat->room->name }}</strong>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="fw-bold text-info">{{ App\Models\Session::formatDecimalHours($stat->total_hours) }}</span>
                                                                <br>
                                                                {{-- <small class="text-white-50">{{ number_format($stat->total_hours, 1) }}h</small> --}}
                                                            </td>
                                                            <td class="text-white">{{ $stat->session_count }}</td>
                                                            <td>
                                                                <span
                                                                    class="fw-bold text-success">{{ number_format($stat->total_revenue, 2) }}
                                                                    JD</span>
                                                            </td>
                                                            <td>
                                                                <div class="pricing-details">
                                                                    <!-- Original Total -->
                                                                    <div class="mb-1">
                                                                        <small class="text-white-50 fw-bold">Original:</small>
                                                                        <span class="text-white">{{ number_format($stat->original_total, 2) }} JD</span>
                                                                    </div>
                                                                    
                                                                    <!-- Final Total -->
                                                                    <div class="mb-1">
                                                                        <small class="text-white-50 fw-bold">Final:</small>
                                                                        <span class="fw-bold text-success">{{ number_format($stat->total_revenue, 2) }} JD</span>
                                                                    </div>
                                                                    
                                                                    <!-- Adjustments/Discounts -->
                                                                    @if($stat->total_adjustments > 0)
                                                                        <div class="mb-1">
                                                                            <span class="badge bg-warning text-dark px-2 py-1" style="font-size: 0.7rem;">
                                                                                <i class="fas fa-arrow-up me-1"></i>
                                                                                +{{ number_format($stat->total_adjustments, 2) }} JD
                                                                            </span>
                                                                        </div>
                                                                    @endif
                                                                    
                                                                    @if($stat->total_discounts > 0)
                                                                        <div class="mb-1">
                                                                            <span class="badge bg-danger text-white px-2 py-1" style="font-size: 0.7rem;">
                                                                                <i class="fas fa-percentage me-1"></i>
                                                                                -{{ number_format($stat->total_discounts, 2) }} JD
                                                                            </span>
                                                                        </div>
                                                                    @endif
                                                                    
                                                                    @if($stat->total_adjustments == 0 && $stat->total_discounts == 0)
                                                                        <small class="text-white-50 fst-italic">No adjustments</small>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="progress progress-custom">
                                                                    <div class="progress-bar bg-info"
                                                                        style="width: {{ min($stat->utilization_percentage, 100) }}%">
                                                                    </div>
                                                                </div>
                                                                <small
                                                                    class="text-white-50">{{ number_format($stat->utilization_percentage, 1) }}%</small>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-door-open text-muted display-4 mb-3"></i>
                                            <p class="text-muted">No room data available for this period</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Cafeteria Items Performance -->
                            <div class="col-lg-6">
                                <div class="glass-card p-4 h-100 slide-in">
                                    <h5 class="text-white fw-bold mb-4 d-flex align-items-center">
                                        <i class="fas fa-utensils text-success me-2"></i>
                                        Most Ordered Cafeteria Items
                                    </h5>
                                    @if (count($cafeteriaStats) > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover glass-table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-white">Item</th>
                                                        <th class="text-white">Quantity</th>
                                                        <th class="text-white">Orders</th>
                                                        <th class="text-white">Sales</th>
                                                        <th class="text-white">Cost</th>
                                                        <th class="text-white">Actual Revenue</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (array_slice($cafeteriaStats, 0, 8) as $stat)
                                                        <tr>
                                                            <td>
                                                                <strong>{{ $stat['cafeteriaItem']->name ?? 'Unknown Item' }}</strong>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge bg-primary rounded-pill">{{ $stat['total_quantity'] }}x</span>
                                                            </td>
                                                            <td>{{ $stat['order_count'] }}</td>
                                                            <td>
                                                                <span
                                                                    class="fw-bold text-success">{{ number_format($stat['total_revenue'], 2) }}
                                                                    JD</span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="fw-bold text-warning">{{ number_format($stat['total_cost'], 2) }}
                                                                    JD</span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="fw-bold {{ $stat['actual_revenue'] >= 0 ? 'text-info' : 'text-danger' }}">{{ number_format($stat['actual_revenue'], 2) }}
                                                                    JD</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-utensils text-muted display-4 mb-3"></i>
                                            <p class="text-white-50">No cafeteria orders in this period</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Daily Performance Chart -->
                        @if (count($dailyStats) > 0)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="glass-card p-4 slide-in">
                                        <h5 class="text-white fw-bold mb-4 d-flex align-items-center">
                                            <i class="fas fa-calendar-day text-info me-2"></i>
                                            Daily Performance Trend
                                        </h5>
                                        <div class="row">
                                            @foreach ($dailyStats as $day)
                                                <div class="col-md-2 mb-3">
                                                    <div class="text-center p-3 day-stat-card">
                                                        <div class="fw-bold text-info">
                                                            {{ Carbon\Carbon::parse($day->date)->format('M j') }}</div>
                                                        <div class="small text-white-50 mb-2">
                                                            {{ Carbon\Carbon::parse($day->date)->format('D') }}</div>
                                                        <div class="fw-bold text-white">{{ $day->session_count }} sessions</div>
                                                        <div class="text-success small">
                                                            {{ number_format($day->total_revenue, 2) }} JD</div>
                                                        <div class="progress progress-custom mt-2">
                                                            <div class="progress-bar bg-success"
                                                                style="width: {{ $day->total_hours > 0 ? min(($day->total_hours / 50) * 100, 100) : 0 }}%">
                                                            </div>
                                                        </div>
                                                        <small
                                                            class="text-white-50">{{ App\Models\Session::formatDecimalHours($day->total_hours) }}</small>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Peak Hours Analysis -->
                        @if (count($peakHours) > 0)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="glass-card p-4 slide-in">
                                        <h5 class="text-white fw-bold mb-4 d-flex align-items-center">
                                            <i class="fas fa-fire text-danger me-2"></i>
                                            Peak Hours Analysis
                                        </h5>
                                        <div class="row">
                                            @foreach ($peakHours as $index => $hour)
                                                <div class="col-md-4 mb-3">
                                                    <div class="text-center p-4 stat-card">
                                                        <div class="display-6 fw-bold text-white">
                                                            {{ str_pad($hour->hour, 2, '0', STR_PAD_LEFT) }}:00</div>
                                                        <div class="h5 text-white">{{ $hour->session_count }} Sessions</div>
                                                        <div class="small text-white-50">Avg Revenue:
                                                            {{ number_format($hour->avg_revenue, 2) }} JD</div>
                                                        <div class="mt-2">
                                                            <span class="badge bg-{{ ['primary', 'success', 'info'][$index] }}">
                                                                Peak #{{ $index + 1 }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- No Report Generated State -->
                        <div class="row">
                            <div class="col-12">
                                <div class="glass-card p-5 text-center slide-in">
                                    <div class="mb-4">
                                        <i class="fas fa-chart-bar text-info" style="font-size: 4rem;"></i>
                                    </div>
                                    <h4 class="fw-bold text-white mb-3">Ready to Generate Your Report</h4>
                                    <p class="text-white-50 mb-4">
                                        Select your preferred date range and time period, then click "Generate Report"
                                        to
                                        view comprehensive analytics about your gaming center performance.
                                    </p>
                                    <div class="row justify-content-center">
                                        <div class="col-md-8">
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <div class="p-3 bg-light rounded text-center">
                                                        <i class="fas fa-dollar-sign text-success mb-2"></i>
                                                        <div class="fw-bold">Revenue Analysis</div>
                                                        <small class="text-muted">Track earnings</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="p-3 bg-light rounded text-center">
                                                        <i class="fas fa-door-open text-primary mb-2"></i>
                                                        <div class="fw-bold">Room Performance</div>
                                                        <small class="text-muted">Usage insights</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="p-3 bg-light rounded text-center">
                                                        <i class="fas fa-utensils text-warning mb-2"></i>
                                                        <div class="fw-bold">Cafeteria Trends</div>
                                                        <small class="text-muted">Popular items</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($reportGenerated)
                        <!-- Executive Summary -->
                        <div class="glass-card p-4 mb-4 slide-in">
                            <h5 class="text-white mb-3">
                                <i class="fas fa-crown text-warning me-2"></i>Executive Summary
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="stat-card text-center">
                                        <div class="stat-icon bg-success bg-opacity-20">
                                            <i class="fas fa-chart-line text-success"></i>
                                        </div>
                                        <h6 class="text-white-50 mb-1">Revenue Growth</h6>
                                        <h4 class="text-white mb-0">
                                            @if($executiveSummary->revenue_growth >= 0)
                                                <span class="text-success">+{{ number_format($executiveSummary->revenue_growth, 1) }}%</span>
                                            @else
                                                <span class="text-danger">{{ number_format($executiveSummary->revenue_growth, 1) }}%</span>
                                            @endif
                                        </h4>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-card text-center">
                                        <div class="stat-icon bg-info bg-opacity-20">
                                            <i class="fas fa-users text-info"></i>
                                        </div>
                                        <h6 class="text-white-50 mb-1">Session Growth</h6>
                                        <h4 class="text-white mb-0">
                                            @if($executiveSummary->session_growth >= 0)
                                                <span class="text-success">+{{ number_format($executiveSummary->session_growth, 1) }}%</span>
                                            @else
                                                <span class="text-danger">{{ number_format($executiveSummary->session_growth, 1) }}%</span>
                                            @endif
                                        </h4>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-card text-center">
                                        <div class="stat-icon bg-warning bg-opacity-20">
                                            <i class="fas fa-dollar-sign text-warning"></i>
                                        </div>
                                        <h6 class="text-white-50 mb-1">Avg Spend/Customer</h6>
                                        <h4 class="text-white mb-0">{{ number_format($executiveSummary->avg_spend_per_customer, 2) }} JD</h4>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-card text-center">
                                        <div class="stat-icon bg-primary bg-opacity-20">
                                            <i class="fas fa-utensils text-primary"></i>
                                        </div>
                                        <h6 class="text-white-50 mb-1">Cafeteria %</h6>
                                        <h4 class="text-white mb-0">{{ number_format($executiveSummary->gaming_vs_cafeteria, 1) }}%</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4 text-center">
                                    <small class="text-white-50">Best Day: <strong class="text-success">{{ $executiveSummary->best_day }}</strong></small><br>
                                    <small class="text-success">{{ number_format($executiveSummary->best_day_revenue, 2) }} JD</small>
                                </div>
                                <div class="col-md-4 text-center">
                                    <small class="text-white-50">Best Room: <strong class="text-info">{{ $executiveSummary->best_room }}</strong></small><br>
                                    <small class="text-info">{{ number_format($executiveSummary->best_room_revenue, 2) }} JD</small>
                                </div>
                                <div class="col-md-4 text-center">
                                    <small class="text-white-50">Peak Hour: <strong class="text-warning">{{ $executiveSummary->best_hour }}</strong></small>
                                </div>
                            </div>
                        </div>

                        <!-- Day of Week Analysis -->
                        <div class="glass-card p-4 mb-4 slide-in">
                            <h5 class="text-white mb-3">
                                <i class="fas fa-calendar-week text-primary me-2"></i>Day of Week Performance
                            </h5>
                            <div class="row">
                                @foreach($dayOfWeekStats as $dayStats)
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="day-stat-card h-100">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="text-white mb-0">{{ $dayStats->day_name }}</h6>
                                                <span class="badge bg-primary">{{ $dayStats->session_count }} sessions</span>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-white-50">Revenue</small>
                                                <h5 class="text-success mb-1">{{ number_format($dayStats->revenue, 2) }} JD</h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <small class="text-white-50">Avg Duration</small>
                                                    <div class="text-info">{{ number_format($dayStats->avg_duration, 1) }}h</div>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-white-50">Avg/Session</small>
                                                    <div class="text-warning">{{ number_format($dayStats->avg_revenue_per_session, 2) }} JD</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Revenue Goals Tracking -->
                        <div class="glass-card p-4 mb-4 slide-in">
                            <h5 class="text-white mb-3">
                                <i class="fas fa-target text-success me-2"></i>Revenue Goals & Tracking
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="goal-progress-card">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="text-white mb-0">Current Period Goal</h6>
                                            <span class="badge bg-{{ $revenueGoals->goal_percentage >= 100 ? 'success' : ($revenueGoals->goal_percentage >= 75 ? 'warning' : 'danger') }}">
                                                {{ number_format($revenueGoals->goal_percentage, 1) }}%
                                            </span>
                                        </div>
                                        <div class="progress mb-2" style="height: 10px;">
                                            <div class="progress-bar bg-{{ $revenueGoals->goal_percentage >= 100 ? 'success' : ($revenueGoals->goal_percentage >= 75 ? 'warning' : 'danger') }}" 
                                                 style="width: {{ min($revenueGoals->goal_percentage, 100) }}%"></div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <small class="text-white-50">{{ number_format($revenueGoals->current_revenue, 2) }} JD</small>
                                            <small class="text-white-50">{{ number_format($revenueGoals->period_goal, 2) }} JD</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="goal-progress-card">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="text-white mb-0">Monthly Goal (Last 30 Days)</h6>
                                            <span class="badge bg-{{ $revenueGoals->monthly_progress >= 100 ? 'success' : ($revenueGoals->monthly_progress >= 75 ? 'warning' : 'danger') }}">
                                                {{ number_format($revenueGoals->monthly_progress, 1) }}%
                                            </span>
                                        </div>
                                        <div class="progress mb-2" style="height: 10px;">
                                            <div class="progress-bar bg-{{ $revenueGoals->monthly_progress >= 100 ? 'success' : ($revenueGoals->monthly_progress >= 75 ? 'warning' : 'danger') }}" 
                                                 style="width: {{ min($revenueGoals->monthly_progress, 100) }}%"></div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <small class="text-white-50">{{ number_format($revenueGoals->last_30_days, 2) }} JD</small>
                                            <small class="text-white-50">{{ number_format($revenueGoals->monthly_goal, 2) }} JD</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4 text-center">
                                    <div class="stat-mini">
                                        <i class="fas fa-calendar-day text-primary me-1"></i>
                                        <span class="text-white-50">Daily Average:</span>
                                        <strong class="text-white">{{ number_format($revenueGoals->daily_average, 2) }} JD</strong>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="stat-mini">
                                        <i class="fas fa-bullseye text-success me-1"></i>
                                        <span class="text-white-50">Daily Goal:</span>
                                        <strong class="text-success">{{ number_format($revenueGoals->daily_goal, 2) }} JD</strong>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="stat-mini">
                                        <i class="fas fa-chart-bar text-info me-1"></i>
                                        <span class="text-white-50">Need/Day:</span>
                                        <strong class="text-info">{{ number_format(max(0, ($revenueGoals->period_goal - $revenueGoals->current_revenue) / max(1, \Carbon\Carbon::parse($this->startDate)->diffInDays(\Carbon\Carbon::parse($this->endDate)) + 1)), 2) }} JD</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Last 30 Days Trend -->
                        <div class="glass-card p-4 mb-4 slide-in">
                            <h5 class="text-white mb-3">
                                <i class="fas fa-chart-area text-info me-2"></i>Last 30 Days Revenue Trend
                            </h5>
                            <div class="trend-chart-container mb-3">
                                <div class="trend-chart">
                                    @php
                                        $revenues = array_column($last30DaysTrend, 'revenue');
                                        $maxRevenue = max($revenues);
                                        $minRevenue = min($revenues);
                                        $range = $maxRevenue - $minRevenue;
                                    @endphp
                                    @foreach($last30DaysTrend as $index => $day)
                                        @php
                                            $height = $range > 0 ? (($day['revenue'] - $minRevenue) / $range) * 100 : 50;
                                            $height = max(5, $height); // Minimum height for visibility
                                        @endphp
                                        <div class="trend-bar" 
                                             style="height: {{ $height }}%;"
                                             data-bs-toggle="tooltip" 
                                             title="{{ $day['date'] }} ({{ $day['day_name'] }}): {{ number_format($day['revenue'], 2) }} JD - {{ $day['sessions'] }} sessions">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <small class="text-white-50">Highest Day</small>
                                    <div class="text-success">{{ number_format($maxRevenue, 2) }} JD</div>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-white-50">Lowest Day</small>
                                    <div class="text-danger">{{ number_format($minRevenue, 2) }} JD</div>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-white-50">Average</small>
                                    <div class="text-info">{{ number_format(array_sum(array_column($last30DaysTrend, 'revenue')) / count($last30DaysTrend), 2) }} JD</div>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-white-50">Total Sessions</small>
                                    <div class="text-warning">{{ array_sum(array_column($last30DaysTrend, 'sessions')) }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        console.log('Reports page loaded with analytics');
        
        // Add smooth scrolling to report sections
        document.querySelectorAll('.slide-in').forEach((element, index) => {
            element.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>
@endpush
