@extends('install.layouts.install', [
    'class' => 'bg-secondary',
    'activeTab' => $tab
])

@section('content')

<form role="form" method="POST" action="{{ \Request::getRequestUri() }}">

{{ @csrf_field() }}


    <div class="card bg-white shadow border-0">
        <div class="card-header">
            <h4 class="text-uppercase ls-1 py-3 mb-0">Permissions</h4>
        </div>
        <div class="card-body">

        <table class="table align-items-center table-flush table-bordered">

                <?php

                $requirements['/storage/framework'] = substr(sprintf('%o', fileperms( storage_path('framework')) ), -4) >= 775 ;
                $requirements['/storage/logs'] = substr(sprintf('%o', fileperms( storage_path('logs')) ), -4) >= 775 ;
                $requirements['/bootstrap/cache'] = substr(sprintf('%o', fileperms( base_path('bootstrap/cache')) ), -4) >= 775 ;
                $requirements['/public/uploads'] = substr(sprintf('%o', fileperms( public_path('uploads')) ), -4) >= 775 ;


                ?>
                <tbody>
                @foreach($requirements as $key => $value)
                  <tr>
                    <td>
                        {{ $key }} 
                    </td>
                    <td>
                        @if($value)
                            <span class="text-success"><i class="ni ni-check-bold"></i></span> 
                        @else
                            <span class="text-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col">
                    <a href="{{ url('install/server-requirements') }}" class="btn btn-secondary">Previous</a>
                </div>
                <div class="col text-right">
                    <button type="submit" class="btn btn-info">Next</a>
                </div>
            </div>
        </div>
    </div>

</form>


@endsection
