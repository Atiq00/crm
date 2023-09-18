@extends('install.layouts.install', [
    'class' => 'bg-secondary',
    'activeTab' => 'home'
])

@section('content')

<form role="form" method="POST" action="{{ route('login') }}">


    <div class="card bg-white shadow border-0">
        <div class="card-header">
            <h4 class="text-uppercase ls-1 py-3 mb-0">Welcome</h4>
        </div>
        <div class="card-body">
            <p>Welcome to installer, here you can easily install application. Click next button to proceed.</p>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col">
                </div>
                <div class="col text-right">
                    <a href="{{ url('install/server-requirements') }}" class="btn btn-info">Next</a>
                </div>
            </div>
        </div>
    </div>

</form>


@endsection
