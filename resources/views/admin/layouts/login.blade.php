<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> {{ __('labels.login') }} | {{ setting('site_title') }}</title>

        <!-- Favicon -->
        <link href="{{ asset('admin') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('admin') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('admin') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Admin CSS -->
        <link type="text/css" href="{{ asset('admin') }}/css/admin.css?v=1.0.0" rel="stylesheet">
    </head>
    <body class="{{ $class ?? '' }}">

        <div class="main-content">
            @yield('content')
        </div>

        <script src="{{ asset('admin') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('admin') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        
        @stack('js')
        
        <!-- Admin JS -->
        <script src="{{ asset('admin') }}/js/admin.js?v=1.0.0"></script>
        <script src="https://unpkg.com/feather-icons"></script>
        <script>
            feather.replace()
        </script>
    </body>
</html>