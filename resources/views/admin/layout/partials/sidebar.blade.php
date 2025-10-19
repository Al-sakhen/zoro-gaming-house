<style>
    /* Modern Sidebar Styling */
    .main-sidebar {
        background: linear-gradient(180deg, #1a1d29 0%, #2c3e50 50%, #34495e 100%) !important;
        box-shadow: 2px 0 15px rgba(0, 0, 0, 0.2) !important;
        border-right: 1px solid rgba(52, 73, 94, 0.3);
        transition: all 0.3s ease;
    }

    .main-sidebar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(0, 52, 154, 0.05) 0%, rgba(52, 73, 94, 0.05) 100%);
        pointer-events: none;
        z-index: 0;
    }

    .sidebar {
        position: relative;
        z-index: 1;
    }

    /* Modern Brand Logo Section */
    .brand-link {
        background: linear-gradient(135deg, #00349a 0%, #0056d3 100%) !important;
        border-bottom: 3px solid rgba(255, 255, 255, 0.1);
        padding: 1.2rem !important;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .brand-link::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        transform: rotate(45deg);
        animation: brandGlow 4s ease-in-out infinite;
    }

    @keyframes brandGlow {

        0%,
        100% {
            opacity: 0.3;
        }

        50% {
            opacity: 0.7;
        }
    }

    .brand-link img {
        position: relative;
        z-index: 1;
        border: 4px solid rgba(255, 255, 255, 0.3) !important;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }

    .brand-link:hover img {
        transform: scale(1.05);
        border-color: rgba(255, 255, 255, 0.8) !important;
        box-shadow: 0 12px 48px rgba(0, 0, 0, 0.4);
    }

    .brand-text {
        position: relative;
        z-index: 1;
    }

    .brand-text h6 {
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    /* Enhanced User Panel */
    .user-panel {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px !important;
        padding: 0.75rem !important;
        margin: 0.75rem 0.5rem !important;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .user-panel:hover {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    }

    .user-panel .user-info a {
        color: #ffffff !important;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: block;
    }

    .user-panel .user-info a:hover {
        color: #00d4ff !important;
        text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
    }

    .user-panel .btn-danger {
        background: linear-gradient(135deg, #ff4757 0%, #ff3838 100%) !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 0.5rem 0.75rem !important;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 71, 87, 0.3);
        position: relative;
        overflow: hidden;
    }

    .user-panel .btn-danger::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .user-panel .btn-danger:hover::before {
        left: 100%;
    }

    .user-panel .btn-danger:hover {
        background: linear-gradient(135deg, #ff3838 0%, #e55656 100%) !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 71, 87, 0.4);
    }

    /* Modern Navigation Menu */
    .nav-sidebar {
        padding: 0 0.5rem;
    }

    .nav-sidebar .nav-item {
        margin-bottom: 0.25rem;
    }

    .nav-sidebar .nav-link {
        border-radius: 12px !important;
        margin-bottom: 0.125rem;
        padding: 0.65rem 1rem !important;
        color: rgba(255, 255, 255, 0.8) !important;
        background: transparent !important;
        border: 1px solid transparent;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        font-weight: 500;
    }

    .nav-sidebar .nav-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.6s;
    }

    .nav-sidebar .nav-link:hover::before {
        left: 100%;
    }

    .nav-sidebar .nav-link:hover {
        color: #ffffff !important;
        background: linear-gradient(135deg, rgba(0, 52, 154, 0.2) 0%, rgba(0, 86, 211, 0.2) 100%) !important;
        border-color: rgba(0, 52, 154, 0.3);
        transform: translateX(4px);
        box-shadow: 0 6px 24px rgba(0, 52, 154, 0.15);
    }

    .nav-sidebar .nav-link.active {
        background: linear-gradient(135deg, #00349a 0%, #0056d3 100%) !important;
        color: #ffffff !important;
        border-color: rgba(255, 255, 255, 0.2);
        transform: translateX(4px);
        box-shadow: 0 6px 24px rgba(0, 52, 154, 0.25);
    }

    .nav-sidebar .nav-link.active::after {
        content: '';
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 60%;
        background: linear-gradient(180deg, #00d4ff 0%, #ffffff 100%);
        border-radius: 2px;
        animation: activeGlow 2s ease-in-out infinite;
    }

    @keyframes activeGlow {

        0%,
        100% {
            opacity: 0.7;
        }

        50% {
            opacity: 1;
        }
    }

    /* Enhanced Icons */
    .nav-sidebar .nav-icon {
        width: 20px !important;
        text-align: center;
        margin-right: 0.5rem !important;
        font-size: 0.95rem !important;
        transition: all 0.3s ease;
    }

    .nav-sidebar .nav-link:hover .nav-icon {
        transform: scale(1.1);
        text-shadow: 0 0 10px rgba(255, 255, 255, 0.4);
    }

    .nav-sidebar .nav-link.active .nav-icon {
        color: #00d4ff !important;
        transform: scale(1.08);
        text-shadow: 0 0 15px rgba(0, 212, 255, 0.5);
    }

    /* Modern Text Styling */
    .nav-sidebar .nav-link div {
        flex: 1;
    }

    .nav-sidebar .nav-link p {
        margin: 0 !important;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.025em;
        transition: all 0.3s ease;
        line-height: 1.1;
    }

    .nav-sidebar .nav-link small {
        font-size: 0.65rem !important;
        opacity: 0.7;
        transition: all 0.3s ease;
        line-height: 1;
    }

    .nav-sidebar .nav-link:hover p {
        letter-spacing: 0.05em;
    }

    .nav-sidebar .nav-link:hover small {
        opacity: 1;
        color: #00d4ff !important;
    }

    .nav-sidebar .nav-link.active small {
        color: #00d4ff !important;
        opacity: 1;
    }

    /* Icon-specific styling */
    .nav-link .fa-home {
        color: #ffd93d;
    }

    .nav-link .fa-cogs {
        color: #ff6b6b;
    }

    .nav-link .fa-utensils {
        color: #4ecdc4;
    }

    .nav-link .fa-chart-pie {
        color: #45b7d1;
    }

    .nav-link .fa-clock {
        color: #96ceb4;
    }

    .nav-link.active .fa-home,
    .nav-link.active .fa-cogs,
    .nav-link.active .fa-utensils,
    .nav-link.active .fa-chart-pie,
    .nav-link.active .fa-clock {
        color: #00d4ff !important;
    }

    /* Responsive Enhancements */
    @media (max-width: 768px) {
        .main-sidebar {
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.3) !important;
        }

        .brand-link {
            padding: 1rem !important;
        }

        .brand-link img {
            height: 80px !important;
        }

        .nav-sidebar .nav-link {
            padding: 0.5rem 0.75rem !important;
        }

        .nav-sidebar .nav-link:hover {
            transform: translateX(2px);
        }

        .nav-sidebar .nav-link.active {
            transform: translateX(2px);
        }
    }

    /* Hover Sound Effect (Visual) */
    .nav-sidebar .nav-link:hover {
        animation: hoverPulse 0.3s ease-out;
    }

    @keyframes hoverPulse {
        0% {
            transform: translateX(0) scale(1);
        }

        50% {
            transform: translateX(4px) scale(1.02);
        }

        100% {
            transform: translateX(8px) scale(1);
        }
    }

    /* Loading Animation */
    .sidebar {
        animation: slideInLeft 0.6s ease-out;
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-100%);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Enhanced Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link d-flex flex-column justify-content-center align-items-center">
        <div class="logo-container">
            <img src="{{ asset('zoro-gaming.jpg') }}" alt="Zoro Gaming House"
                style="height: 120px; border-radius: 50%; object-fit: cover;">
        </div>
        <div class="brand-text mt-2 text-center">
            <h6 class="mb-0 fw-bold text-white" style="font-size: 0.9rem; letter-spacing: 0.05em;">
                ZORO GAMING
            </h6>
            <small class="text-white-50" style="font-size: 0.7rem; text-transform: uppercase;">
                Management Hub
            </small>
        </div>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Enhanced Sidebar user panel -->
        <div class="user-panel pb-3 mt-3 mb-3 d-flex">
            <div class="info d-flex align-items-center w-100">
                <div class="user-info flex-grow-1">
                    <a href="#" class="d-block">
                        {{ auth()->user()->name }}
                    </a>
                    <small class="text-white-50" style="font-size: 0.75rem;">
                        Administrator
                    </small>
                </div>
                <div class="user-actions">
                    <a class="btn btn-sm btn-danger" href="{{ route('logout') }}" title="Logout"
                        data-bs-toggle="tooltip">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </div>


        <!-- Enhanced Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                {{-- ----------------------------- --}}
                {{-- ********* Dashboard Home ********* --}}
                {{-- ----------------------------- --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" @class(['nav-link', 'active' => request()->routeIs('dashboard')])>
                        <div>
                            <p class="mb-0">
                                <i class="nav-icon fas fa-home"></i>
                                Dashboard
                            </p>
                            <br>
                            <small class="text-white-50" style="font-size: 0.7rem;">
                                Real-time overview
                            </small>
                        </div>
                    </a>
                </li>

                {{-- ----------------------------- --}}
                {{-- ********* Rooms Management ********* --}}
                {{-- ----------------------------- --}}
                <li class="nav-item">
                    <a href="{{ route('rooms.management') }}" @class([
                        'nav-link',
                        'active' => request()->routeIs('rooms.management'),
                    ])>
                        <div>
                            <p class="mb-0">
                                <i class="nav-icon fas fa-cogs"></i>
                                Rooms Management
                            </p>
                            <br>
                            <small class="text-white-50" style="font-size: 0.7rem;">
                                Configure gaming spaces
                            </small>
                        </div>
                    </a>
                </li>

                {{-- ----------------------------- --}}
                {{-- ********* Cafeteria Management ********* --}}
                {{-- ----------------------------- --}}
                <li class="nav-item">
                    <a href="{{ route('cafeteria') }}" @class(['nav-link', 'active' => request()->routeIs('cafeteria')])>
                        <div>
                            <p class="mb-0">
                                <i class="nav-icon fas fa-utensils"></i>
                                Cafeteria
                            </p>
                            <br>
                            <small class="text-white-50" style="font-size: 0.7rem;">
                                Manage food & drinks
                            </small>
                        </div>
                    </a>
                </li>

                {{-- ----------------------------- --}}
                {{-- ********* Cafeteria Analytics ********* --}}
                {{-- ----------------------------- --}}
                <li class="nav-item">
                    <a href="{{ route('cafeteria.overview') }}" @class([
                        'nav-link',
                        'active' => request()->routeIs('cafeteria.overview'),
                    ])>
                        <div>
                            <p class="mb-0">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                Cafeteria Analytics
                            </p>
                            <br>
                            <small class="text-white-50" style="font-size: 0.7rem;">
                                Sales insights & trends
                            </small>
                        </div>
                    </a>
                </li>

                {{-- ----------------------------- --}}
                {{-- ********* Sessions Overview ********* --}}
                {{-- ----------------------------- --}}
                <li class="nav-item">
                    <a href="{{ route('sessions') }}" @class(['nav-link', 'active' => request()->routeIs('sessions')])>
                        <div>
                            <p class="mb-0">
                                <i class="nav-icon fas fa-clock"></i>
                                Sessions History
                            </p>
                            <br>
                            <small class="text-white-50" style="font-size: 0.7rem;">
                                Track gaming activity
                            </small>
                        </div>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
