<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>
    Gaming Center Dashboard
</title>
{{-- FAVICON --}}
<link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
{{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}
<link rel="stylesheet" href="{{ asset('dashboard/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('dashboard/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('dashboard/plugins/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('dashboard/dist/css/adminlte.min.css') }}">
<link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap.min.css') }}">

@vite(['resources/css/app.css'])
