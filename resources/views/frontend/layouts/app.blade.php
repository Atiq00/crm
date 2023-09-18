<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('frontend.layouts.partials.styles')
    </head>

  <body class="page bg-theme">


    @include('frontend.layouts.partials.nav')
  

    <div class="wrapper">

      <main class="page-content">
        @include('frontend.layouts.partials.notification')
        @yield('content')
    </main>

    <footer class="footer footer-light mt-8 py-4">
      @include('frontend.layouts.footers.footer')
    </footer>

  </div>

    @include('frontend.layouts.partials.scripts')
  
    @stack('js')
    
</body>

</html>
