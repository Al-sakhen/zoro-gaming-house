@extends('admin.layout.app')

@section('breadcrumb')
    @include('admin.layout.partials.page-header', [
        'title' => 'Rooms ',
        'links' => [
            [
                'name' => 'Dashboard',
                'url' => route('dashboard'),
            ],
        ],
    ])
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <livewire:dashboard />
        </div>
    </div>
@endsection
