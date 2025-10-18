<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layout.partials.head')

    @stack('styles')

</head>

<body class="hold-transition sidebar-mini">

    <div class="container-fluid">
        @yield('content')
    </div>
    <!-- REQUIRED SCRIPTS -->
    @include('admin.layout.partials.scripts')
    @stack('scripts')
</body>

</html>
