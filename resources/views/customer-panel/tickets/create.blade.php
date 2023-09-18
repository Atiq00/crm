@extends('frontend.layouts.app', ['body_class' => 'bg-default', 'nav_class' => 'navbar-theme'])

@section('content')
<div class="container">
  

<div class="section-page-header text-center">
  <div class="container d-flex align-items-center">

  </div>
</div>

<div class="row">
  <div class="col">

    <div class="card bg-white mt-7 mx-lg-9">

      <div class="card-header bg-white">
          <div class="row align-items-center">
            <div class="col-12 col-lg-8">
              <h3 class="mb-0">{{ __('frontend.create_new_ticket') }} </h3>
            </div>
          </div>
        </div>

      <div class="card-body">

            <form action="{{route('customer.ticket_save')}}" method="post" id="my-form" enctype="multipart/form-data">
                @csrf
                @method('post')
                  <div class="form-group">
                    <label class="form-control-label" for="input-department">{{ __('labels.departments') }}</label>
                    <select id="input-department" class="form-control" name="department_id" required autofocus>
                      <option value="">{{ __('labels.select_department') }}</option>
                      @foreach($departments as $department)
                        <option value="{{$department->id}}">{{$department->name}}</option>
                      @endforeach
                    </select>
                    @if ($errors->has('department_id'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('department_id') }}</strong>
                          </span>
                      @endif
                  </div>

                  <div class="form-group">
                    <label class="form-control-label" for="input-priority">{{ __('labels.priority') }}</label>
                    <select id="input-priority" class="form-control" name="priority_id" required>
                      @foreach($priorities as $priority)
                        <option value="{{$priority->id}}">{{$priority->name}}</option>
                      @endforeach
                    </select>
                    @if ($errors->has('priority_id'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('priority_id') }}</strong>
                          </span>
                      @endif
                  </div>

                  <div class="form-group">
                    <label class="form-control-label" for="input-name">{{ __('labels.subject') }}</label>
                    <input type="text" id="input-name" name="title" class="form-control" required placeholder="{{ __('labels.subject') }}" required minlength="3" value="">
                    @if ($errors->has('title'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('title') }}</strong>
                          </span>
                      @endif
                  </div>

              <div class="form-group">
                <label class="form-control-label" for="input-description">{{ __('labels.description') }}</label>
                <textarea class="form-control" name="description" id="input-description" rows="12"  required minlength="15" placeholder="{{ __('labels.description') }}"></textarea>
                    @if ($errors->has('description'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('description') }}</strong>
                          </span>
                      @endif
              </div>

              <div class="form-group">
                <label for="exampleFormControlFile1">{{ __('labels.attachment') }}</label>
                <input type="file" class="form-control-file" name="reply_attachments" multiple id="exampleFormControlFile1">
                    @if ($errors->has('reply_attachments'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('reply_attachments') }}</strong>
                          </span>
                      @endif
              </div>

              

              <div class="form-group">
                  @if(setting('RECAPTCH_TYPE')=='GOOGLE')
                    <div class="g-recaptcha" data-sitekey="{{setting('GOOGLE_RECAPTCHA_KEY')}}"></div>
                     @if ($errors->has('g-recaptcha-response'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                        </span>
                    @endif
                  @endif

                </div>

                <div class="form-group mt-5">
                  <button type="submit" class="btn btn-md btn-primary"><i data-feather="save" width="15" stroke-width="2"></i> &nbsp; {{ __('labels.submit') }}</button>
            </div>
            
          </form>
      
      </div>

  </div>

</div>


</div>
@endsection


@push('js')


<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script>
  $(document).ready( function () {
    $('#basic-datatables').DataTable({
      "searching":   false,
      "paging":   false,
      // "ordering": false,
      "info":     false
    });
} );


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