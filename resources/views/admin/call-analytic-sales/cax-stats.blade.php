@extends('admin.layouts.app', ['current_page' => 'call-analytic-sales-stats'])
@section('content')
    @include('admin.layouts.headers.cards', [
        'title' => 'Call-Analytic-Sales-Stats',
    ])
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header border-0">
                        @if ($errors->any())
                            <div class="alert alert-danger"style="color: white;">
                                <strong class="text-secondary">Oops!</strong> There were some
                                problems with your
                                input.<br><br>
                                <ul style="color: white;padding-left:20px">
                                    @foreach ($errors->all() as $error)
                                        <li style="color: white">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if ($message = Session::get('success'))
                            <div class="col-lg-12 text-center"
                                style="margin-top:10px;margin-bottom: 10px; padding-left:50px">
                                <div class="alert alert-success" style="color: white">
                                    {{ $message }}
                                </div>
                            </div>
                        @endif
                        <div class="col-md-2 col-lg-3  p-0 form-group">
                            <span> <strong> Daily Wise Goal </strong> </span>
                        </div>
                            <div class="col-xl-6 col-md-3 p-0">
                                <div class="card bg-gradient-info">
                                    <!-- Card body -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total Count
                                                    Daily Wise</h5>
                                                <span class="h2 font-weight-bold mb-0 text-white"> 6300
                                                </span>
                                            </div>
                                            <div class="col-auto">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>



                <div class="card shadow">
                    <div class="card-header border-0">
                        @if ($errors->any())
                            <div class="alert alert-danger"style="color: white;">
                                <strong class="text-secondary">Oops!</strong> There were some
                                problems with your
                                input.<br><br>
                                <ul style="color: white;padding-left:20px">
                                    @foreach ($errors->all() as $error)
                                        <li style="color: white">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if ($message = Session::get('success'))
                            <div class="col-lg-12 text-center"
                                style="margin-top:10px;margin-bottom: 10px; padding-left:50px">
                                <div class="alert alert-success" style="color: white">
                                    {{ $message }}
                                </div>
                            </div>
                        @endif
                        <div class="col-md-2 col-lg-3  p-0 form-group">
                            <span> <strong> Daily Team Achievement </strong> </span>
                        </div>
                        <form action="{{ route('call-analytic-sales.stats') }}" method="GET">
                            <div class="row">
                                <div class="col-md-3 col-lg-3 form-group">
                                    <label>From Date</label>
                                    <input type="date" name="start_date_ach" value="{{ @$_GET['start_date_ach'] }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-3 col-lg-3 form-group">
                                    <label>To Date</label>
                                    <input type="date" name="end_date_ach" value="{{ @$_GET['end_date_ach'] }}"
                                        class="form-control">

                                </div>
                                <div class="col-md-1 col-lg-3 form-group">
                                    <label>&nbsp;</label>
                                    <input type="submit" name="submit" value="search"
                                        class="form-control btn btn-primary">
                                </div>

                            </div>
                            <div class="col-xl-6 col-md-6 p-0">
                                <div class="card bg-gradient-info">
                                    <!-- Card body -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase text-muted mb-0 text-white">Daily Achievement</h5>
                                                <span class="h2 font-weight-bold mb-0 text-white">
                                                    {{ (!empty($dailycount1)) ? (@$dailycount1) : 0}}
                                                </span>
                                            </div>
                                            <div class="col-auto">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>




                <div class="card shadow">
                    <div class="card-header border-0">
                        @if ($errors->any())
                            <div class="alert alert-danger"style="color: white;">
                                <strong class="text-secondary">Oops!</strong> There were some
                                problems with your
                                input.<br><br>
                                <ul style="color: white;padding-left:20px">
                                    @foreach ($errors->all() as $error)
                                        <li style="color: white">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if ($message = Session::get('success'))
                            <div class="col-lg-12 text-center"
                                style="margin-top:10px;margin-bottom: 10px; padding-left:50px">
                                <div class="alert alert-success" style="color: white">
                                    {{ $message }}
                                </div>
                            </div>
                        @endif
                        <div class="col-md-2 col-lg-3  p-0 form-group">
                            <span> <strong> Daily Achieve Goal </strong> </span>
                        </div>
                        <form action="{{ route('call-analytic-sales.stats') }}" method="GET">
                            <div class="row">
                                <div class="col-md-2 col-lg-3 form-group">
                                    <label>From Date</label>
                                    <input type="date" name="start_date_ach_goal" value="{{ @$_GET['start_date_ach_goal'] }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-2 col-lg-3 form-group">
                                    <label>To Date</label>
                                    <input type="date" name="end_date_ach_goal" value="{{ @$_GET['end_date_ach_goal'] }}"
                                        class="form-control">

                                </div>
                                <div class="col-md-1 col-lg-3 form-group">
                                    <label>&nbsp;</label>
                                    <input type="submit" name="submit" value="search"
                                        class="form-control btn btn-primary">
                                </div>

                            </div>
                            <div class="col-xl-6 col-md-6 p-0">
                                <div class="card bg-gradient-info">
                                    <!-- Card body -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase text-muted mb-0 text-white">Daily Achieve Goal</h5>
                                                <span class="h2 font-weight-bold mb-0 text-white">{{number_format((float)@$per,2, '.' , '') }}%
                                                </span>
                                                {{-- round(@$per) --}}
                                            </div>
                                            <div class="col-auto">
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header border-0">
                        @if ($errors->any())
                            <div class="alert alert-danger"style="color: white;">
                                <strong class="text-secondary">Oops!</strong> There were some
                                problems with your
                                input.<br><br>
                                <ul style="color: white;padding-left:20px">
                                    @foreach ($errors->all() as $error)
                                        <li style="color: white">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if ($message = Session::get('success'))
                            <div class="col-lg-12 text-center"
                                style="margin-top:10px;margin-bottom: 10px; padding-left:50px">
                                <div class="alert alert-success" style="color: white">
                                    {{ $message }}
                                </div>
                            </div>
                        @endif
                        <div class="col-md-2 col-lg-3  p-0 form-group">
                            <span> <strong> Monthly Wise Goal </strong> </span>
                        </div>
                            <div class="col-xl-6 col-md-3 p-0">
                                <div class="card bg-gradient-info">
                                    <!-- Card body -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total Count
                                                    Month Wise</h5>
                                                <span class="h2 font-weight-bold mb-0 text-white"> 126000
                                                </span>
                                            </div>
                                            <div class="col-auto">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>



                <div class="card shadow">
                    <div class="card-header border-0">
                        @if ($errors->any())
                            <div class="alert alert-danger"style="color: white;">
                                <strong class="text-secondary">Oops!</strong> There were some
                                problems with your
                                input.<br><br>
                                <ul style="color: white;padding-left:20px">
                                    @foreach ($errors->all() as $error)
                                        <li style="color: white">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if ($message = Session::get('success'))
                            <div class="col-lg-12 text-center"
                                style="margin-top:10px;margin-bottom: 10px; padding-left:50px">
                                <div class="alert alert-success" style="color: white">
                                    {{ $message }}
                                </div>
                            </div>
                        @endif
                        <div class="col-md-2 col-lg-3  p-0 form-group">
                            <span> <strong> Monthly Team Achievement </strong> </span>
                        </div>
                        <form action="{{ route('call-analytic-sales.stats') }}" method="GET">
                            <div class="row">
                                <div class="col-md-3 col-lg-3 form-group">
                                    <label>From Date</label>
                                    <input type="date" name="start_date_ach_month" value="{{ @$_GET['start_date_ach_month'] }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-3 col-lg-3 form-group">
                                    <label>To Date</label>
                                    <input type="date" name="end_date_ach_month" value="{{ @$_GET['end_date_ach_month'] }}"
                                        class="form-control">

                                </div>
                                <div class="col-md-1 col-lg-3 form-group">
                                    <label>&nbsp;</label>
                                    <input type="submit" name="submit" value="search"
                                        class="form-control btn btn-primary">
                                </div>

                            </div>
                            <div class="col-xl-6 col-md-6 p-0">
                                <div class="card bg-gradient-info">
                                    <!-- Card body -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase text-muted mb-0 text-white">Monthly Achievement</h5>
                                                <span class="h2 font-weight-bold mb-0 text-white">
                                                    {{ (!empty($dailycount2)) ? (@$dailycount2) : 0}}
                                                </span>
                                            </div>
                                            <div class="col-auto">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>




                <div class="card shadow">
                    <div class="card-header border-0">
                        @if ($errors->any())
                            <div class="alert alert-danger"style="color: white;">
                                <strong class="text-secondary">Oops!</strong> There were some
                                problems with your
                                input.<br><br>
                                <ul style="color: white;padding-left:20px">
                                    @foreach ($errors->all() as $error)
                                        <li style="color: white">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if ($message = Session::get('success'))
                            <div class="col-lg-12 text-center"
                                style="margin-top:10px;margin-bottom: 10px; padding-left:50px">
                                <div class="alert alert-success" style="color: white">
                                    {{ $message }}
                                </div>
                            </div>
                        @endif
                        <div class="col-md-2 col-lg-3  p-0 form-group">
                            <span> <strong> Monthly Achieve Goal </strong> </span>
                        </div>
                        <form action="{{ route('call-analytic-sales.stats') }}" method="GET">
                            <div class="row">
                                <div class="col-md-2 col-lg-3 form-group">
                                    <label>From Date</label>
                                    <input type="date" name="start_date_ach_goal_month" value="{{ @$_GET['start_date_ach_goal_month'] }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-2 col-lg-3 form-group">
                                    <label>To Date</label>
                                    <input type="date" name="end_date_ach_goal_month" value="{{ @$_GET['end_date_ach_goal_month'] }}"
                                        class="form-control">

                                </div>
                                <div class="col-md-1 col-lg-3 form-group">
                                    <label>&nbsp;</label>
                                    <input type="submit" name="submit" value="search"
                                        class="form-control btn btn-primary">
                                </div>

                            </div>
                            <div class="col-xl-6 col-md-6 p-0">
                                <div class="card bg-gradient-info">
                                    <!-- Card body -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase text-muted mb-0 text-white"> Monthly Achieve Goal</h5>
                                                <span class="h2 font-weight-bold mb-0 text-white">{{number_format((float)@$per_month,2, '.' , '') }}%
                                                </span>
                                                {{-- round(@$per) --}}
                                            </div>
                                            <div class="col-auto">
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.layouts.footers.auth')
@endsection
