@extends('admin.layouts.app', [ 'current_page' => 'general_settings' ])

@section('content')

<style>
    /*div.dataTables_wrapper div.dataTables_filter{
        text-align: left;
    }

    div.dataTables_length{
        text-align: right;
    }*/
</style>

    @include('admin.layouts.headers.cards', ['title' => __('labels.general_settings')])
    
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-3">
                @include('admin.settings.partials.sidebar', ['settingSidebarActive' => 'general'])
            </div>
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{__('labels.general_settings') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('settings.general.store') }}" id="my-form" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('post')

                            <div class="pl-lg-4">

                                <div class="form-group{{ $errors->has('site_title') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-site_title">{{__('labels.site_title') }}</label>
                                    <input type="text" name="site_title" id="input-site_title" class="form-control {{ $errors->has('site_title') ? ' is-invalid' : '' }}" placeholder="{{__('labels.site_title') }}" value="{{ old('site_title', setting('site_title')) }}" required>

                                    @if ($errors->has('site_title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('site_title') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('site_description') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-site_description">{{__('labels.site_description') }}</label>

                                    <textarea name="site_description" id="input-site_description" class="form-control {{ $errors->has('site_description') ? ' is-invalid' : '' }}" placeholder="{{__('labels.site_description') }}" rows="5" required>{{ old('site_description', setting('site_description')) }}</textarea>

                                    @if ($errors->has('site_description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('site_description') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label" for="upload_image">{{__('labels.site_logo') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="site_logo" id="upload_image" lang="en">
                                        <label class="custom-file-label text-left" for="upload_image"><i data-feather="upload" width="15"></i> {{__('labels.select_file') }}</label>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <img src="{{ asset('uploads/logo/'.setting('site_logo')).'?'.time() }}" width="100" id="preview-image" alt="" />
                                </div>


                                <div class="form-group">
                                    <label class="form-control-label" for="upload_image_favicon">{{__('labels.site_favicon') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="site_favicon" id="upload_image_favicon" lang="en">
                                        <label class="custom-file-label text-left" for="upload_image_favicon"><i data-feather="upload" width="15"></i> {{__('labels.select_file') }}</label>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <img src="{{ asset('uploads/logo/'.setting('site_favicon')).'?'.time() }}" width="20" id="preview-favicon" alt="" />
                                </div>

                                <div class="text-left">
                                    <button type="submit" class="btn btn-info mt-4">{{__('labels.update') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{__('labels.social_media_settings') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('settings.general.store_social_media') }}" id="my-form" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('post')

                            <div class="pl-lg-4">

                                <div class="form-group{{ $errors->has('social_media_facebook') ? ' has-danger' : '' }}">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fab fa-facebook-f"></i>
                                            </span>
                                        </div>
                                        <input type="url" name="social_media_facebook" id="input-social_media_facebook" class="form-control {{ $errors->has('social_media_facebook') ? ' is-invalid' : '' }}" placeholder="{{ __('Facebook') }}" value="{{ old('social_media_facebook', setting('social_media_facebook')) }}">
                                    </div>

                                    @if ($errors->has('social_media_facebook'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('social_media_facebook') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('social_media_instagram') ? ' has-danger' : '' }}">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fab fa-instagram"></i>
                                            </span>
                                        </div>
                                        <input type="url" name="social_media_instagram" id="input-social_media_instagram" class="form-control {{ $errors->has('social_media_instagram') ? ' is-invalid' : '' }}" placeholder="{{ __('Instagram') }}" value="{{ old('social_media_instagram', setting('social_media_instagram')) }}">
                                    </div>

                                    @if ($errors->has('social_media_instagram'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('social_media_instagram') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('social_media_twitter') ? ' has-danger' : '' }}">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fab fa-twitter"></i>
                                            </span>
                                        </div>
                                        <input type="url" name="social_media_twitter" id="input-social_media_twitter" class="form-control {{ $errors->has('social_media_twitter') ? ' is-invalid' : '' }}" placeholder="{{ __('Twitter') }}" value="{{ old('social_media_twitter', setting('social_media_twitter')) }}" />
                                    </div>

                                    @if ($errors->has('social_media_twitter'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('social_media_twitter') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('social_media_pinterest') ? ' has-danger' : '' }}">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fab fa-pinterest-p"></i>
                                            </span>
                                        </div>
                                        <input type="url" name="social_media_pinterest" id="input-social_media_pinterest" class="form-control {{ $errors->has('social_media_pinterest') ? ' is-invalid' : '' }}" placeholder="{{ __('Pinterest') }}" value="{{ old('social_media_pinterest', setting('social_media_pinterest')) }}">
                                    </div>

                                    @if ($errors->has('social_media_pinterest'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('social_media_pinterest') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('social_media_youtube') ? ' has-danger' : '' }}">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fab fa-youtube"></i>
                                            </span>
                                        </div>
                                        <input type="url" name="social_media_youtube" id="input-social_media_youtube" class="form-control {{ $errors->has('social_media_youtube') ? ' is-invalid' : '' }}" placeholder="{{ __('Pinterest') }}" value="{{ old('social_media_youtube', setting('social_media_youtube')) }}">
                                    </div>

                                    @if ($errors->has('social_media_youtube'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('social_media_youtube') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('social_media_envato') ? ' has-danger' : '' }}">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <img src="{{ asset('admin') }}/img/icons/common/envato-2-458277.png" width="15" alt="">
                                            </span>
                                        </div>
                                        <input type="url" name="social_media_envato" id="input-social_media_envato" class="form-control {{ $errors->has('social_media_envato') ? ' is-invalid' : '' }}" placeholder="{{ __('Pinterest') }}" value="{{ old('social_media_envato', setting('social_media_envato')) }}">
                                    </div>

                                    @if ($errors->has('social_media_envato'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('social_media_envato') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="text-left">
                                    <button type="submit" class="btn btn-info mt-4">{{__('labels.update') }}</button>
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
            $('#upload_image_favicon').on('change', (e) => {
                preview_image(e, 'preview-favicon');
            });
        </script>
        @endpush
