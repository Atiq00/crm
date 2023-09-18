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
            <div class="col-12 col-md-8">
              <h3 class="mb-0">{{ __('frontend.edit_profile') }} </h3>
            </div>
          </div>
        </div>

      <div class="card-body">

          <div class="pl-lg-4">
            <form action="{{route('customer.profile_update')}}" method="post" id="my-form">
              @csrf
                <div class="form-group">
                  <label class="form-control-label" for="input-name">{{ __('labels.name') }}</label>
                  <input type="text" id="input-name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" placeholder="{{ __('labels.name') }}" value="{{ old('name') ?? $customer->name}}">
                  @if ($errors->has('name'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('name') }}</strong>
                      </span>
                  @endif
                </div>

                <div class="form-group">
                  <label class="form-control-label" for="input-email">{{ __('labels.email') }}</label>
                  <input type="email" id="input-email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="{{ __('labels.email') }}" value="{{ old('email') ?? $customer->email}}">
                  @if ($errors->has('email'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('email') }}</strong>
                      </span>
                  @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-md btn-primary"><i data-feather="save" width="15" stroke-width="2"></i> {{ __('labels.update') }}</button>
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
