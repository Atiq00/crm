@extends('admin.layouts.app', [ 'current_page' => 'dashboard' ])

@section('content')
    @include('admin.layouts.headers.cards', [ 'title' => 'Dashboard' ])
 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>First Name : </strong>
                {{ $first_name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Last Name : </strong>
                {{ $last_name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Phone : </strong>
                {{ $phone }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email : </strong>
                {{ $email }}
            </div>
        </div>
		 <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>app_date_time : </strong>
                {{ $app_date_time }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Street : </strong>
                {{ $street }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>City : </strong>
                {{ $city }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>State : </strong>
                {{ $state }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Zip : </strong>
                {{ $zipcode }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Comments : </strong>
                {{ $notes }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Bill : </strong>
                {{ $electric_bill }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>credit_score : </strong>
                {{ $credit_score }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>home_owner : </strong>
                {{ $home_owner }}
            </div>
        </div>

    </div>
@endsection