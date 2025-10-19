@push('styles')
    <style>
        /* Modern Session Summary Styling */
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }

        .session-summary-container {
            background-image: url('/gaming-bg.svg');
            background-size: 100px 100px;
            background-repeat: repeat;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
        }

        .session-summary-container::before {
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
        .session-card {
            border-radius: 24px;
            overflow: hidden;
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: none;
            animation: fadeIn 0.6s ease-out;
        }

        /* Modern Header */
        .session-header {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .session-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            transform: rotate(45deg);
        }

        .session-header h4 {
            position: relative;
            z-index: 1;
            margin: 0;
            font-weight: 700;
        }

        /* Section Cards */
        .info-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid rgba(102, 126, 234, 0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .info-card h5 {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            font-weight: 700;
        }

        .info-card .icon-wrapper {
            background: rgba(102, 126, 234, 0.1);
            border-radius: 12px;
            padding: 0.5rem;
            margin-right: 0.75rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Pricing Display */
        .price-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .price-item:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 1.1rem;
            color: #4caf50;
        }

        .price-value {
            font-weight: 600;
            color: #667eea;
        }

        /* Modern Table */
        .modern-table {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: none;
        }

        .modern-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .modern-table thead th {
            border: none;
            font-weight: 600;
            padding: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
        }

        .modern-table tbody tr {
            transition: all 0.2s ease;
        }

        .modern-table tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .modern-table tbody td {
            border: none;
            padding: 1rem;
            vertical-align: middle;
        }

        /* Form Elements */
        .modern-form-group {
            margin-bottom: 1.5rem;
        }

        .modern-form-group label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
            display: block;
        }

        .modern-input {
            border-radius: 12px;
            border: 2px solid rgba(102, 126, 234, 0.2);
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
            text-align: left !important;
            /* Force left alignment */
        }

        .modern-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            outline: none;
        }

        /* Input adjustments for better UX */
        .form-control {
            text-align: left !important;
        }

        /* Improved input styling */
        .duration-input {
            font-weight: bold;
            font-size: 1.1rem;
            text-align: left !important;
            background: #f8f9fa;
            border: 2px solid #e9ecef;
        }

        .duration-input:focus {
            background: white;
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }

        .price-input {
            font-weight: bold;
            text-align: left !important;
            background: #f0f9ff;
            border: 2px solid #bfdbfe;
        }

        .price-input:focus {
            background: white;
            border-color: #3b82f6;
        }

        /* Discount Section */
        .discount-section {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border-radius: 20px;
            padding: 2rem;
            border: 2px solid rgba(255, 193, 7, 0.3);
            position: relative;
            overflow: hidden;
        }

        .discount-section::before {
            content: '';
            position: absolute;
            top: -10px;
            right: -10px;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ffd93d 0%, #ff9500 100%);
            border-radius: 50%;
            opacity: 0.3;
        }

        .discount-alert {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            border-radius: 16px;
            border: 1px solid rgba(23, 162, 184, 0.3);
            padding: 1.5rem;
            margin-top: 1rem;
        }

        .discount-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .discount-item {
            text-align: center;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 12px;
        }

        /* Badge Styling */
        .modern-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 1rem;
        }

        /* Modern Buttons */
        .btn-modern {
            border-radius: 16px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: none;
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

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-cancel {
            background: linear-gradient(135deg, #ffd93d 0%, #ff9500 100%);
            color: white;
        }

        .btn-cancel:hover {
            background: linear-gradient(135deg, #ff9500 0%, #e8850a 100%);
            color: white;
        }

        .btn-confirm {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
        }

        .btn-confirm:hover {
            background: linear-gradient(135deg, #ee5a52 0%, #dc4444 100%);
            color: white;
        }

        /* Empty State */
        .empty-orders {
            text-align: center;
            padding: 3rem;
            background: rgba(248, 249, 250, 0.8);
            border-radius: 16px;
            border: 2px dashed rgba(102, 126, 234, 0.3);
        }

        .empty-orders i {
            color: #667eea;
            margin-bottom: 1rem;
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
            .session-header {
                padding: 1.5rem;
            }

            .info-card {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .discount-section {
                padding: 1.5rem;
            }

            .btn-modern {
                padding: 0.75rem 1.5rem;
                font-size: 0.875rem;
            }

            .modern-table thead th,
            .modern-table tbody td {
                padding: 0.75rem 0.5rem;
                font-size: 0.875rem;
            }
        }
    </style>
@endpush

<div class="session-summary-container">
    <div class="container-fluid py-4 fade-in">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="card session-card">
                    <div class="card-header session-header">
                        <h4 class="card-title mb-0 d-flex align-items-center">
                            <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                                <i class="fas fa-stop-circle"></i>
                            </div>
                            <span>End Session Confirmation</span>
                        </h4>
                    </div>

                    <div class="card-body p-4">
                        <!-- Session Overview Card -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="info-card">
                                    <h5 class="text-primary">
                                        <div class="icon-wrapper">
                                            <i class="fas fa-desktop text-primary"></i>
                                        </div>
                                        Session Information
                                    </h5>
                                    <div class="row g-3">
                                        <div class="col-md-2 col-6">
                                            <div class="text-center p-3 bg-white rounded-3">
                                                <i class="fas fa-door-open text-success mb-2 fs-5"></i>
                                                <small class="text-muted d-block">Room</small>
                                                <div class="fw-bold">{{ $session->room->name }}</div>
                                                @if ($session->room->type)
                                                    <div class="text-muted small text-capitalize">
                                                        {{ $session->room->type }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        @if ($session->room->isPlaystation() && $session->controller_count)
                                            <div class="col-md-2 col-6">
                                                <div class="text-center p-3 bg-white rounded-3">
                                                    <i class="fas fa-gamepad text-info mb-2 fs-5"></i>
                                                    <small class="text-muted d-block">Controllers</small>
                                                    <div class="fw-bold">{{ $session->controller_count }}</div>
                                                    <div class="text-muted small">players</div>
                                                </div>
                                            </div>
                                        @endif
                                        <div
                                            class="col-md-{{ $session->room->isPlaystation() && $session->controller_count ? '2' : '3' }} col-6">
                                            <div class="text-center p-3 bg-white rounded-3">
                                                <i class="fas fa-play text-primary mb-2 fs-5"></i>
                                                <small class="text-muted d-block">Started</small>
                                                <div class="fw-bold">{{ $session->started_at->format('H:i') }}</div>
                                                <div class="text-muted small">{{ $session->started_at->format('M j') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="col-md-{{ $session->room->isPlaystation() && $session->controller_count ? '3' : '3' }} col-6">
                                            <div class="text-center p-3 bg-white rounded-3">
                                                <i class="fas fa-clock text-warning mb-2 fs-5"></i>
                                                <small class="text-muted d-block">Actual Duration</small>
                                                <div class="fw-bold">{{ $session->getFormattedDuration() }}</div>
                                                <div class="text-muted small">{{ $session->getDurationInMinutes() }} min
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="text-center p-3 bg-white rounded-3">
                                                <i class="fas fa-money-bill text-success mb-2 fs-5"></i>
                                                <small class="text-muted d-block">
                                                    @if ($session->room->isPlaystation() && $session->controller_count)
                                                        Gaming ({{ $session->controller_count }} Controllers)
                                                    @else
                                                        Original Gaming
                                                    @endif
                                                </small>
                                                <div class="fw-bold">{{ number_format($originalGamingPrice, 2) }} JD
                                                </div>
                                                @if ($session->room->isPlaystation() && $session->controller_count)
                                                    <div class="text-muted small">
                                                        {{ number_format($session->getPricePerHour(), 2) }} JD/hour
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Duration Adjustment Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="info-card">
                                    <h5 class="text-primary">
                                        <div class="icon-wrapper">
                                            <i class="fas fa-edit text-primary"></i>
                                        </div>
                                        Duration Adjustment (Optional)
                                    </h5>
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-3">
                                            <div class="modern-form-group">
                                                <label for="adjustedHours">Hours</label>
                                                <input type="number" wire:model.live="adjustedHours"
                                                    class="form-control modern-input duration-input" id="adjustedHours"
                                                    min="0" placeholder="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="modern-form-group">
                                                <label for="adjustedMinutes">Minutes</label>
                                                <div class="input-group">
                                                    <input type="number" wire:model.live="adjustedMinutes"
                                                        class="form-control modern-input duration-input"
                                                        id="adjustedMinutes" min="0" max="59"
                                                        placeholder="0">
                                                    <button type="button" wire:click="resetMinutes"
                                                        class="btn btn-outline-secondary" title="Reset to 0">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="alert alert-info mb-0">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <strong>Adjusted Duration:</strong> {{ $this->getFormattedDuration() }}
                                                <br>
                                                <strong>Adjusted Gaming Price:</strong>
                                                {{ number_format($adjustedGamingPrice, 2) }} JD
                                                @if ($gamingPriceAdjustment != 0)
                                                    <span
                                                        class="badge {{ $gamingPriceAdjustment > 0 ? 'bg-success' : 'bg-danger' }} ms-2">
                                                        {{ $gamingPriceAdjustment > 0 ? '+' : '' }}{{ number_format($gamingPriceAdjustment, 2) }}
                                                        JD
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Summary Section -->
                        <div class="row mb-1">
                            <div class="col-12">
                                <div class="discount-section">
                                    <h5 class="text-warning fw-bold mb-3">
                                        <i class="fas fa-calculator me-2"></i>
                                        Final Pricing & Discount
                                    </h5>

                                    <div class="row g-4">
                                        <!-- Discount Controls -->
                                        <div class="col-md-6">
                                            <div class="modern-form-group">
                                                <label for="discountAmount">Discount Amount (JD)</label>
                                                <input type="number" wire:model.live="discountAmount"
                                                    class="form-control modern-input price-input" id="discountAmount"
                                                    min="0" step="0.01" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="modern-form-group">
                                                <label for="finalPrice">Final Total (JD)</label>
                                                <input type="number" wire:model.live="finalPriceAfterDiscount"
                                                    class="form-control modern-input price-input" id="finalPrice"
                                                    min="0" step="0.01" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price Breakdown -->
                                    <div class="discount-alert">
                                        <div class="row g-3">
                                            <div class="col-md-3 col-6">
                                                <div class="text-center">
                                                    <div class="small text-muted">Gaming Price</div>
                                                    <div class="fw-bold fs-5">
                                                        {{ number_format($adjustedGamingPrice, 2) }} JD</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <div class="text-center">
                                                    <div class="small text-muted">Cafeteria Total</div>
                                                    <div class="fw-bold fs-5 text-primary">
                                                        {{ number_format($session->calculateCafeteriaTotal(), 2) }} JD
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <div class="text-center">
                                                    <div class="small text-muted">Discount
                                                        {{ $discountPercentage > 0 ? '(' . $discountPercentage . '%)' : '' }}
                                                    </div>
                                                    <div class="fw-bold fs-5 text-danger">
                                                        -{{ number_format($discountAmount, 2) }} JD</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <div class="text-center">
                                                    <div class="small text-muted">Final Total</div>
                                                    <div class="fw-bold fs-4 text-success">
                                                        {{ number_format($finalPriceAfterDiscount, 2) }} JD</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cafeteria Orders Section -->
                        @if ($tempOrders->count() > 0)
                            <div class="mb-4">
                                <div class="info-card">
                                    <h5 class="text-primary">
                                        <div class="icon-wrapper">
                                            <i class="fas fa-utensils text-primary"></i>
                                        </div>
                                        Cafeteria Orders ({{ $tempOrders->count() }} items)
                                    </h5>
                                    <div class="table-responsive">
                                        <table class="table modern-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($tempOrders as $order)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                                    <i class="fas fa-utensils text-primary"></i>
                                                                </div>
                                                                <div>
                                                                    <div class="fw-semibold">
                                                                        {{ $order->cafeteriaItem->name }}</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="modern-badge">{{ $order->units_count }}</span>
                                                        </td>
                                                        <td>{{ number_format($order->price_per_unit, 2) }} JD</td>
                                                        <td class="fw-bold text-success">
                                                            {{ number_format($order->total_price, 2) }} JD</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- No orders message is commented out as it's not needed when there are no orders --}}
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="card-footer bg-transparent border-0 p-4 pt-0">
                        <div class="alert alert-warning mb-4">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-exclamation-triangle me-3 mt-1"></i>
                                <div>
                                    <strong>Important:</strong> Once you confirm, this session will be permanently ended
                                    and all orders will be saved to the final orders table.
                                    <br><small class="text-muted">If you cancel or close this window, the session will
                                        continue running.</small>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 col-12">
                                <button type="button" wire:click="cancelEndSession"
                                    class="btn btn-cancel btn-modern w-100 py-3">
                                    <i class="fas fa-times me-2"></i>
                                    Cancel & Resume
                                </button>
                            </div>
                            <div class="col-md-6 col-12">
                                <button type="button" wire:click="confirmEndSession" id="confirmEndSessionBtn"
                                    class="btn btn-confirm btn-modern w-100 py-3" wire:loading.attr="disabled">
                                    <span wire:target="confirmEndSession"
                                        wire:loading.class="spinner-border spinner-border-sm"
                                        wire:loading.style="width: 1rem; height: 1rem; margin-right: 0.5rem;">
                                        @if ($finalPriceAfterDiscount > 0)
                                            <span class="visually-hidden">Loading...</span>
                                        @else
                                            <span class="visually-hidden">Loading...</span>
                                        @endif

                                    </span>
                                    <span wire:loading.remove>
                                        <i class="fas fa-check me-2"></i>
                                        End Session ({{ number_format($finalPriceAfterDiscount, 2) }} JD)
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            let isSessionEnded = false;


            Livewire.on('closeSessionWindow', () => {
                // Close the popup window and refresh parent
                if (window.opener) {
                    window.opener.Livewire.dispatch('refreshComponent');
                }
                window.close();
            });

            // Function to close window safely
            function closeWindowSafely() {
                if (window.opener) {
                    window.opener.location.reload();
                }
                setTimeout(() => {
                    window.close();
                }, 500);
            }

            // Check session flash data on page load
            @if (session('sessionConfirmed'))
                isSessionEnded = true;
                closeWindowSafely();
            @endif

            @if (session('sessionEnded'))
                isSessionEnded = true;
                closeWindowSafely();
            @endif

            @if (session('closeWindow'))
                closeWindowSafely();
            @endif

            // Listen for Livewire component updates (after actions complete)
            document.addEventListener('livewire:navigated', () => {
                // Check for session ended flag after component update
                const messageElement = document.querySelector('.alert-success');
                if (messageElement && messageElement.textContent.includes('Session ended successfully')) {
                    isSessionEnded = true;
                    setTimeout(closeWindowSafely, 1000);
                }
            });

            // Alternative: Listen for successful form submission
            window.addEventListener('livewire:commit', ({
                detail: {
                    succeed
                }
            }) => {
                if (succeed) {
                    // Check if this was a session ending action
                    setTimeout(() => {
                        const messageElement = document.querySelector('.alert-success');
                        if (messageElement && messageElement.textContent.includes(
                                'Session ended successfully')) {
                            isSessionEnded = true;
                            closeWindowSafely();
                        }
                    }, 100);
                }
            });

            // Direct button click monitoring
            const confirmBtn = document.getElementById('confirmEndSessionBtn');
            if (confirmBtn) {
                confirmBtn.addEventListener('click', function() {
                    // Wait for Livewire action to complete, then check for success
                    setTimeout(() => {
                        // Check multiple times in case of delay
                        for (let i = 0; i < 5; i++) {
                            setTimeout(() => {
                                const messageElement = document.querySelector(
                                    '.alert-success');
                                const alertSuccess = document.querySelector(
                                    '.alert.alert-success');

                                if ((messageElement && messageElement.textContent.includes(
                                        'Session ended successfully')) ||
                                    (alertSuccess && alertSuccess.textContent.includes(
                                        'Session ended successfully'))) {
                                    isSessionEnded = true;
                                    closeWindowSafely();
                                    return;
                                }
                            }, i * 500); // Check every 500ms for up to 2.5 seconds
                        }
                    }, 200);
                });
            }

            // Handle window beforeunload event (when user clicks X or closes tab)
            window.addEventListener('beforeunload', function(event) {
                // Only trigger cancel if session wasn't properly ended
                if (!isSessionEnded) {
                    // Use navigator.sendBeacon for reliable async request
                    const formData = new FormData();
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content') || '');

                    // Send async request to cancel session
                    const cancelUrl = '{{ route('session.cancel-on-close', $session) }}';

                    // Try sendBeacon first (most reliable for page unload)
                    if (navigator.sendBeacon) {
                        navigator.sendBeacon(cancelUrl, formData);
                    } else {
                        // Fallback to fetch with keepalive
                        fetch(cancelUrl, {
                            method: 'POST',
                            body: formData,
                            keepalive: true
                        }).catch(() => {
                            // Silent fail - window is closing
                        });
                    }
                }
            });

            // Enhanced communication with parent window
            window.addEventListener('message', function(event) {
                if (event.data === 'checkSessionStatus') {
                    // Respond with current session status
                    if (window.opener) {
                        window.opener.postMessage({
                            type: 'sessionStatus',
                            sessionEnded: isSessionEnded,
                            sessionId: {{ $session->id }}
                        }, '*');
                    }
                }
            });

            // Also listen for page visibility change (additional safety)
            document.addEventListener('visibilitychange', function() {
                if (document.visibilityState === 'hidden' && !isSessionEnded) {
                    // Page is being hidden, might be closing
                    // This is a backup to beforeunload
                    setTimeout(() => {
                        if (!isSessionEnded) {
                            @this.call('handlePopupClosure').catch(() => {
                                // Silent fail if Livewire is no longer available
                            });
                        }
                    }, 100);
                }
            });
        });
    </script>
@endpush
