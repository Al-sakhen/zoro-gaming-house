@extends('admin.layout.app2')

@section('breadcrumb')
    @include('admin.layout.partials.page-header', [
        'title' => 'Talabat Order - ' . $session->room->name,
        'links' => [
            [
                'name' => 'Dashboard',
                'url' => route('dashboard'),
            ],
        ],
    ])
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <livewire:talabat-page :session="$session" />
                </div>
            </div>
        </div>
    </div>
@endsection