@extends('frontend.layouts.app', ['body_class' => 'bg-default', 'nav_class' => 'navbar-theme'])

@section('content')
<div class="container mt-5">

<div class="row">
  <div class="col-12 col-md-4">
    <!-- <div class="section section-page"> -->

      @include('customer-panel.account.partials.sidebar')

    <!-- </div> -->
  </div>
  <div class="col-12 col-md">

    <div class="card bg-white mt-6">

      <div class="card-header bg-white">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">{{ __('frontend.change_password') }} </h3>
            </div>
          </div>
        </div>

      <div class="card-body">

          <div class="pl-lg-4">
            @if (session('password_status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('password_status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <form method="post" action="{{ route('customer.profile_update_password') }}" id="my-form" autocomplete="off">
                @csrf
                <div class="form-group {{ $errors->has('old_password') ? ' has-danger' : '' }}">
                  <label class="form-control-label" for="input-old-password">{{ __('labels.old_password') }}</label>
                  <input type="password" id="input-old-password" name="old_password" class="form-control" required minlength="6" placeholder="{{ __('labels.old_password') }}" />
                  @if ($errors->has('old_password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @endif
                </div>
                <div class="form-group {{ $errors->has('old_password') ? ' has-danger' : '' }}">
                  <label class="form-control-label" for="input-password">{{ __('labels.password') }}</label>
                  <input type="password" id="input-password" name="password" class="form-control" required minlength="6" placeholder="{{ __('labels.password') }}" />
                  @if ($errors->has('password'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif
                </div>
                <div class="form-group {{ $errors->has('old_password') ? ' has-danger' : '' }}">
                  <label class="form-control-label" for="input-confirm-password">{{ __('labels.confirm_password') }}</label>
                  <input type="password" id="input-confirm-password" name="password_confirmation" class="form-control" required minlength="6" placeholder="{{ __('labels.confirm_password') }}" />
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-md btn-primary">{{ __('labels.update') }}</button>
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
