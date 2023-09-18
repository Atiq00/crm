@extends('frontend.layouts.app', ['body_class' => 'bg-default', 'nav_class' => 'navbar-theme'])

@section('content')

<div class="container pt-lg-7">
      <div class="row justify-content-center">
        <div class="col-lg-5">

        @if (session('status'))
            {!! alert_html(session('status'), 'success') !!}
        @endif          
          
          <div class="card bg-white">
            <div class="card-header bg-white text-center py-5">
                <h3>{{ __('frontend.reset_password' ) }}</h3>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              
              <form role="form" id="my-form" action="{{route('customer.send_password')}}" method="post">
                @csrf
                <div class="form-group mb-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" required name="email" placeholder="{!! __('labels.email' ) !!}" autofocus type="email">
                  </div>
                  <span class="text-muted" style="font-size: .9rem;">{!! __('frontend.reset_password_email' ) !!}</span>
                   @if ($errors->has('email'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('email') }}</strong>
                      </span>
                  @endif
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-login my-4"> {{ __('frontend.reset_password' ) }}</button>
                </div>
               

              </form>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-6">
              <a href="{{route('customer.login')}}" class="color-theme"><small>{!! __('frontend.back_to_login' ) !!}</a>
            </div>
            <div class="col-6 text-right">
            </div>
          </div>
        </div>
      </div>
    </div>


@endsection
@push('js')
<script>
if ( document.getElementById('my-form') ) {
  $("#my-form").parsley({
     errorClass: 'is-invalid text-danger',
     // successClass: 'is-valid',
     errorsWrapper: '<span class="form-text text-danger"></span>',
     errorTemplate: '<span></span>',
     trigger: 'change',
     errorsContainer: function(el) {
          return el.$element.closest('.form-group');
      },
   });
}
</script>
@endpush