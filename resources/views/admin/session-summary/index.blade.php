@extends('admin.layout.app2')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <livewire:session-summary :session="$session" />
                </div>
            </div>
        </div>
    </div>
@endsection
