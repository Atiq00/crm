          

          

@if ($message = Session::get('success'))

  <div class="container mt-5">{!! alert_html( $message, 'success' ) !!}</div>

@endif


@if ($message = Session::get('danger'))

  <div class="container mt-5">{!! alert_html( $message, 'danger' ) !!}</div>


@endif


@if ($message = Session::get('warning'))

  <div class="container mt-5">{!! alert_html( $message, 'warning' ) !!}</div>

@endif


@if ($message = Session::get('info'))

  <div class="container mt-5">{!! alert_html( $message, 'info' ) !!}</div>

@endif