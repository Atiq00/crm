@extends('install.layouts.install', [
    'class' => 'bg-secondary',
    'activeTab' => $tab
])

@section('content')

<form role="form" method="POST" action="{{ \Request::getRequestUri() }}">

{{ @csrf_field() }}


    <div class="card bg-white shadow border-0">
        <div class="card-header">
            <h4 class="text-uppercase ls-1 py-3 mb-0">Server Requirments</h4>
        </div>
        <div class="card-body">

        <table class="table align-items-center table-flush table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>PHP {{ phpversion() }}</th>
                        <th width="15%">
                            @if( version_compare(PHP_VERSION, '7.2.5', ">=") )
                                <span class="text-success"><i class="ni ni-check-bold"></i></span>
                            @else
                                <span class="text-danger"><i class="fa fa-times"></i></span>
                            @endif
                        </th>
                    </tr>
                </thead>

                @if( version_compare(PHP_VERSION, '7.2.5', ">=") )

                <?php

                // OpenSSL PHP Extension
                $requirements['openssl'] = extension_loaded("openssl");

                // PDO PHP Extension
                $requirements['pdo'] = defined('PDO::ATTR_DRIVER_NAME');

                // Mbstring PHP Extension
                $requirements['mbstring'] = extension_loaded("mbstring");

                // Tokenizer PHP Extension
                $requirements['tokenizer'] = extension_loaded("tokenizer");

                // XML PHP Extension
                $requirements['xml'] = extension_loaded("xml");

                // CTYPE PHP Extension
                $requirements['ctype'] = extension_loaded("ctype");

                // JSON PHP Extension
                $requirements['json'] = extension_loaded("json");

                // BCMath
                $requirements['bcmath'] = extension_loaded("bcmath");


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

                @else
                <tbody>
                    <tr>
                        <td colspan="2">
                            <div class="alert alert-danger">
                                PHP version must be >= 7.2.5
                            </div>
                        </td>
                    </tr>
                </tbody>
                @endif
            </table>
            
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col">
                    <a href="{{ url('install/') }}" class="btn btn-secondary">Previous</a>
                </div>
                <div class="col text-right">
                    <button type="submit" class="btn btn-info">Next</a>
                </div>
            </div>
        </div>
    </div>

</form>


@endsection
