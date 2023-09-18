@extends('admin.layouts.app', [ 'current_page' => 'solar ' ])

@section('content')


    @include('admin.layouts.headers.cards', ['title' => "solar"])
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Edit Campaign</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('agent.index') }}"> Back</a>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('agent.update',$user->id) }}" method="POST">
            @csrf
            @method('PUT')
             <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <strong>Update Campaign Date</strong>
                        <input type="date" name="campaign_hire_date" value="{{  date('Y-m-d',strtotime($user->campaign_hire_date)) }}" class="form-control" placeholder="Camp hire date">
                    </div>
                </div>
              
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 pl-0">
                <strong>Update Status</strong>
                <select name="camp_status"  class="form-control">
                        <option value="Active" @if ($user->camp_status == 'Active') selected @endif>Active</option>
                        <option value="InActive" @if ($user->camp_status == 'InActive') selected @endif>InActive</option>
                    </select>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 text-left pl-0 pt--1">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>

        </form>

        @include('admin.layouts.footers.auth')



    </div>
@endsection


