@extends('frontend.layouts.app', ['body_class' => 'bg-default', 'nav_class' => 'navbar-theme'])

@section('content')

<div class="container pt-lg-7">
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="card bg-white">
            <div class="card-header bg-white text-center py-5">
                <h3>{{ __('frontend.new_password' ) }}</h3>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              
              <form role="form" method="POST" action="{{ route('customer.password.update') }}" id="my-form">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.email' ) }}" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('labels.password' ) }}" type="password" required>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="{{ __('labels.confirm_password' ) }}" type="password" name="password_confirmation" required>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">{{ __('frontend.reset_password' ) }}</button>
                            </div>
                        </form>
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