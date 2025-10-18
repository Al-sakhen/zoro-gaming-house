<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layout.partials.head')

    @stack('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css"
        integrity="sha512-MQXduO8IQnJVq1qmySpN87QQkiR1bZHtorbJBD0tzy7/0U9+YIC93QWHeGTEoojMVHWWNkoCp8V6OzVSYrX0oQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>

</head>

<body class="hold-transition sidebar-mini">
    {{-- Loading Screen --}}
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('loader.jpg') }}" alt="Gaming Center" height="150">
    </div>
    {{-- @minifyhtml --}}
    <div class="wrapper">
        <!-- Navbar -->
        @include('admin.layout.partials.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('admin.layout.partials.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @yield('breadcrumb')
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Main Footer -->
        @include('admin.layout.partials.footer')
    </div>
    <!-- ./wrapper -->
    {{-- @endminifyhtml --}}

    <!-- REQUIRED SCRIPTS -->
    @include('admin.layout.partials.scripts')
    <script>
        $(document).ready(function() {
            $('.preloader').fadeOut('slow');

            Livewire.hook('element.init', () => {
                window.scrollTo(0, 0);
            })
        });
    </script>
    @stack('scripts')
</body>

</html>
