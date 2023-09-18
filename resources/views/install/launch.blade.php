@extends('install.layouts.install', [
    'class' => 'bg-secondary',
    'activeTab' => 'home'
])

@section('content')

<form role="form" method="POST" action="{{ route('login') }}">


    <div class="card bg-white shadow border-0">
        <div class="card-header">
            <h4 class="text-uppercase ls-1 py-3 mb-0">Launch Application</h4>
        </div>
        <div class="card-body">
            <div class="alert alert-success">
                Congratulations ! {{ env('APP_NAME') }} has been installed. You can explore admin panel & frontend. You can also refer to documentation anytime.
            </div>
            <hr>
            <h3>Admin Login Credentials -</h3>
                    <table class="table table-light">
                        <tbody>
                            <tr>
                                <th class="bg-dark text-white">user</th>
                                <td>admin@gmail.com</td>
                            </tr>
                            <tr>
                                <th class="bg-dark text-white">password</th>
                                <td>admin123</td>
                            </tr>
                        </tbody>
                    </table>
            <hr>
            <h3>User Login Credentials -</h3>
                    <table class="table table-light">
                        <tbody>
                            <tr>
                                <th class="bg-dark text-white">user</th>
                                <td>agent@gmail.com</td>
                            </tr>
                            <tr>
                                <th class="bg-dark text-white">password</th>
                                <td>agent123</td>
                            </tr>
                        </tbody>
                    </table>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col text-right">
                    <a href="{{ url('/') }}" class="btn btn-primary">Frontend</a>
                    <a href="{{ url('/admin/login') }}" class="btn btn-warning">Admin Panel</a>
                </div>
            </div>
        </div>
    </div>

</form>


@endsection
