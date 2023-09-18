@extends('admin.layouts.app', [ 'current_page' => 'api_settings' ])

@section('content')

<style>
    /*div.dataTables_wrapper div.dataTables_filter{
        text-align: left;
    }

    div.dataTables_length{
        text-align: right;
    }*/
</style>

    @include('admin.layouts.headers.cards', ['title' => __('labels.api_settings')])
    
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-3">
                @include('admin.settings.partials.sidebar', ['settingSidebarActive' => 'api'])
            </div>
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0"> {{ __('labels.google_recaptcha') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('settings.api.store') }}" id="my-form" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('post')

                            <div class="pl-lg-4">

                                <div class="form-group{{ $errors->has('RECAPTCH_TYPE') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-RECAPTCH_TYPE">{{ __('labels.enable_disable_recaptcha') }}</label><br>

                                    <label class="custom-toggle">
                                        <input type="checkbox" {{ old('RECAPTCH_TYPE', setting('RECAPTCH_TYPE'))=='GOOGLE'?'checked':'' }} name="RECAPTCH_TYPE" value="GOOGLE">
                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                      </label>                                    

                                    @if ($errors->has('RECAPTCH_TYPE'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('RECAPTCH_TYPE') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('GOOGLE_RECAPTCHA_KEY') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-GOOGLE_RECAPTCHA_KEY">{{ __('labels.recaptcha_site_key') }}</label>
                                    <input type="text" name="GOOGLE_RECAPTCHA_KEY" id="input-GOOGLE_RECAPTCHA_KEY" class="form-control {{ $errors->has('GOOGLE_RECAPTCHA_KEY') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.recaptcha_site_key') }}" value="{{ old('GOOGLE_RECAPTCHA_KEY', setting('GOOGLE_RECAPTCHA_KEY')) }}" >

                                    @if ($errors->has('GOOGLE_RECAPTCHA_KEY'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('GOOGLE_RECAPTCHA_KEY') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('GOOGLE_RECAPTCHA_SECRET') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-GOOGLE_RECAPTCHA_SECRET">{{ __('labels.recaptcha_secret_key') }}</label>
                                    <input type="text" name="GOOGLE_RECAPTCHA_SECRET" id="input-GOOGLE_RECAPTCHA_SECRET" class="form-control {{ $errors->has('GOOGLE_RECAPTCHA_SECRET') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.recaptcha_secret_key') }}" value="{{ old('GOOGLE_RECAPTCHA_SECRET', setting('GOOGLE_RECAPTCHA_SECRET')) }}" >

                                    @if ($errors->has('GOOGLE_RECAPTCHA_SECRET'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('GOOGLE_RECAPTCHA_SECRET') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="text-left">
                                    <button type="submit" class="btn btn-info mt-4">{{ __('labels.update') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        @include('admin.layouts.footers.auth')



    </div>
@endsection


        @push('js')

        <script src="{{ asset('admin') }}/vendor/dropzone/dist/min/dropzone.min.js"></script>

        <script>
            $(document).ready(() => {
                $('#basic-datatable').DataTable();
            });
            $('#upload_image').on('change', (e) => {
                preview_image(e);
            });
        </script>
        @endpush
