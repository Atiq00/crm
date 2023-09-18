@extends('frontend.layouts.app', ['body_class' => 'bg-default', 'nav_class' => 'navbar-theme'])

@section('content')

<div class="container pt-lg-7">
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="card bg-white">
            <div class="card-header bg-white text-center py-5">
                <h3>{{ __('frontend.create_account') }}</h3>
            </div>
            <div class="card-body px-lg-5 py-lg-5">

              <p class="text-center text-muted"><small>{{ __('frontend.already_account') }}</small>
              <a href="{{route('customer.login')}}" class="text-primary"><small> {{ __('frontend.login') }}</small></a></p>

              @if($errors->any())
                {!! alert_html( __('frontend.fill_all_fields'), 'danger') !!}
              @endif
              
              <form role="form" action="{{route('customer.do_register')}}" method="post" id="my-form" autocomplete="off">
                @csrf
                @method('post')

                <div class="form-group mb-3">
                    <label class="form-control-label" for="input-name">{{ __('labels.name') }}<span class="text-danger">*</span> </label>
                    <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" placeholder="{{ __('labels.name') }}" autofocus value="{{old('name')}}" required minlength="3" />
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group mb-3">
                    <label class="form-control-label" for="input-name">{{ __('labels.email') }}<span class="text-danger">*</span> </label>
                  <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.email') }}" name="email" value="{{old('email')}}" required />
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="input-name">{{ __('labels.password') }}<span class="text-danger">*</span> </label>
                  <input type="password" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.password') }}" name="password"  required minlength="6" />
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                @if(setting('RECAPTCH_TYPE')=='GOOGLE')
                  <div class="form-group pt-4">
                      <div class="g-recaptcha" data-sitekey="{{setting('GOOGLE_RECAPTCHA_KEY')}}"></div>
                      @if ($errors->has('g-recaptcha-response'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                          </span>
                      @endif
                  </div>
                @endif


                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" id=" customCheckLogin" value="agreed" name="agree_terms" type="checkbox">
                  <label class="custom-control-label" for=" customCheckLogin">{!! __('frontend.agree_terms' ) !!}</label>
                    @if ($errors->has('agree_terms'))
                        <p class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('agree_terms') }}</strong>
                        </p>
                    @endif
                </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-login my-4"><i data-feather="user" width="20"></i> &nbsp; {{ __('frontend.signup' ) }}</button>
                </div>
                
              </form>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-6">
            </div>
            <div class="col-6 text-right">
              <a href="{{route('customer.login')}}" class="text-primary"><small> {{ __('frontend.login' ) }}</small></a>
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
         successClass: 'is-valid',
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
