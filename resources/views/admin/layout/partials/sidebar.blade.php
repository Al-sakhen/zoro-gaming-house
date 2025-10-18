<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link d-flex flex-column justify-items-center align-items-center">
        <img src="{{ asset('loader.jpg') }}" alt="" style=" height: 120px">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="pb-3 mt-3 mb-3 user-panel d-flex">
            <div class="info d-flex align-items-center">
                <a href="#" class="d-block">
                    {{ auth()->user()->name }}
                </a>
                <a class="py-1 ml-3 btn btn-sm btn-danger" href="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                {{-- ----------------------------- --}}
                {{-- ********* Home ********* --}}
                {{-- ----------------------------- --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" @class(['nav-link', 'active' => request()->routeIs('dashboard')])>
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Home
                        </p>
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
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Rooms
                        </p>
                    </a>
                </li>

                {{-- ----------------------------- --}}
                {{-- ********* Cafeteria Management ********* --}}
                {{-- ----------------------------- --}}
                <li class="nav-item">
                    <a href="{{ route('cafeteria') }}" @class(['nav-link', 'active' => request()->routeIs('cafeteria')])>
                        <i class="nav-icon fas fa-utensils"></i>
                        <p>
                            Cafeteria
                        </p>
                    </a>
                </li>

                {{-- ----------------------------- --}}
                {{-- ********* Cafeteria Overview ********* --}}
                {{-- ----------------------------- --}}
                <li class="nav-item">
                    <a href="{{ route('cafeteria.overview') }}" @class(['nav-link', 'active' => request()->routeIs('cafeteria.overview')])>
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Cafeteria Statistics
                        </p>
                    </a>
                </li>

                {{-- ----------------------------- --}}
                {{-- ********* Sessions Overview ********* --}}
                {{-- ----------------------------- --}}
                <li class="nav-item">
                    <a href="{{ route('sessions') }}" @class(['nav-link', 'active' => request()->routeIs('sessions')])>
                        <i class="nav-icon fas fa-clock"></i>
                        <p>
                            Sessions Overview
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
