<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Install HelpDesk</title>
        <!-- Favicon -->
        <link href="{{ asset('admin') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('admin') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('admin') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- admin CSS -->
        <link type="text/css" href="{{ asset('admin') }}/css/admin.css?v=1.0.0" rel="stylesheet">


        <link rel="stylesheet" href="{{ asset('admin') }}/vendor/animate.css/animate.min.css">
        <link rel="stylesheet" href="{{ asset('admin') }}/vendor/sweetalert2/dist/sweetalert2.min.css">

    </head>
    <body class="{{ $class ?? '' }}">

    
<div class="header py-2 pt-6">
    <div class="container">
        <div class="header-body text-center">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <h1 class="text-info">{{ __('Install HelpDesk') }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="container mt-2 pt-3 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-7">
            
            <!-- 
                Home
                Server Requirments
                Permissions
                Database
                Done
             -->

            <div class="nav-wrapper">
                <ul class="nav nav-pills nav-fill flex-column flex-md-row">
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab=='home'? 'bg-info ' : ($tabIndex > 0 ? 'bg-success' : 'bg-gray') }} text-white mb-sm-5 mb-md-2 py-4">
                            <h3 class="text-white"><i class="ni ni-shop"></i></h3>
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab=='server-requirements'? 'bg-info ' : ($tabIndex > 1 ? 'bg-success' : 'bg-gray') }} text-white mb-sm-5 mb-md-2 py-4">
                            <h3 class="text-white"><i class="ni ni-building"></i></h3>
                            Server Requirements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab=='permissions'? 'bg-info ' : ($tabIndex > 2 ? 'bg-success' : 'bg-gray') }} text-white mb-sm-5 mb-md-2 py-4" id="tabs-icons-text-3-tab">
                            <h3 class="text-white"><i class="ni ni-key-25"></i></h3>
                            Permissions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab=='database'? 'bg-info ' : ($tabIndex > 3 ? 'bg-success' : 'bg-gray') }} text-white mb-sm-5 mb-md-2 py-4" id="tabs-icons-text-3-tab">
                            <h3 class="text-white"><i class="ni ni-money-coins"></i></h3>
                            Database
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab=='launch'? 'bg-info ' : 'bg-gray' }} text-white mb-sm-5 mb-md-2 py-4" id="tabs-icons-text-3-tab">
                            <h3 class="text-white"><i class="ni ni-spaceship"></i></h3>
                            Launch
                        </a>
                    </li>
                </ul>
            </div>


        <div class="main-content">
            @yield('content')
        </div>

            </div>
        </div>
    </div>


        <script src="{{ asset('admin') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('admin') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        
        @stack('js')
        
        <!-- admin JS -->
        <script src="{{ asset('admin') }}/js/admin.js?v=1.0.0"></script>
        <script src="https://unpkg.com/feather-icons"></script>

        <!-- Optional JS -->
        <script src="{{ asset('admin') }}/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
      <script src="{{ asset('admin') }}/vendor/bootstrap-notify/bootstrap-notify.min.js"></script>

        <script>
            feather.replace()


            @if ($message = Session::get('success'))
          
          $.notify({
            // options
            message: '{{ $message }}',
            icon: 'ni ni-check-bold',
          },{
            // settings
            type: 'success',
            offset: 50,
          });

          @endif


          @if ($message = Session::get('error'))
          
          $.notify({
            // options
            message: '{{ $message }}',
            icon: 'fa fa-times',
          },{
            // settings
            type: 'danger',
            offset: 50,
          });

          @endif


          @if ($message = Session::get('warning'))
          
          $.notify({
            // options
            message: '{{ $message }}',
            icon: 'ni ni-bell-55',
          },{
            // settings
            type: 'warning',
            offset: 50,
          });

          @endif


          @if ($message = Session::get('info'))
          
          $.notify({
            // options
            message: '{{ $message }}',
            icon: 'ni ni-bell-55',
          },{
            // settings
            type: 'danger',
            offset: 50,
          });

          @endif


          @if ($errors->any())
          
          $.notify({
            // options
            message: '{{ $message }}',
            icon: 'ni ni-bell-55',
          },{
            // settings
            type: 'danger',
            offset: 50,
          });

          @endif

        </script>


    </body>
</html>