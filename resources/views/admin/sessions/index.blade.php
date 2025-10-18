@extends('admin.layout.app')

@section('page-title', 'Sessions Overview')

@section('content')
    <livewire:sessions />
@endsection

@section('scripts')
    <script>
        // Auto-refresh active sessions every 30 seconds
        setInterval(function() {
            if (window.livewire) {
                window.livewire.emit('refreshComponent');
            }
        }, 30000);
    </script>
@endsection