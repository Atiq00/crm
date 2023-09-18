@extends('admin.layouts.app', [ 'current_page' => 'frontend_settings' ])

@section('content')

<style>
    /*div.dataTables_wrapper div.dataTables_filter{
        text-align: left;
    }

    div.dataTables_length{
        text-align: right;
    }*/
</style>

    @include('admin.layouts.headers.cards', ['title' => __('labels.frontend_settings') ])
    
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-3">
                @include('admin.settings.partials.sidebar', ['settingSidebarActive' => 'frontend'])
            </div>
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{__('labels.theme') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('settings.frontend.store') }}" id="my-form" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('post')

                            <div class="pl-lg-4">
                                
                                <div class="form-group">
                                    <label class="form-control-label" for="upload_image">{{__('labels.front_white_logo') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="frontend_logo" id="upload_image" lang="en">
                                        <label class="custom-file-label text-left" for="upload_image"><i data-feather="upload" width="15"></i> {{__('labels.select_file') }}</label>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <div style="background-color: #222; display: inline-block; padding: 1rem; border-radius: 1rem;">
                                        <img src="{{ asset('uploads/logo/'.setting('frontend_logo')).'?'.time() }}" width="150" id="preview-image" alt="" />
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-control-label" for="frontend_dark_logo">{{__('labels.front_dark_logo') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="frontend_dark_logo" id="frontend_dark_logo" lang="en">
                                        <label class="custom-file-label text-left" for="frontend_dark_logo"><i data-feather="upload" width="15"></i> {{__('labels.select_file') }}</label>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <img src="{{ asset('uploads/logo/'.setting('frontend_dark_logo')).'?'.time() }}" width="150" id="preview-frontend_dark_logo" alt="" />
                                </div>


                                <div class="form-group">
                                    <label class="form-control-label" for="upload_image_favicon">{{__('labels.site_favicon_logo') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="frontend_favicon" id="upload_image_favicon" lang="en">
                                        <label class="custom-file-label text-left" for="upload_image_favicon"><i data-feather="upload" width="15"></i> Select file</label>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <img src="{{ asset('uploads/logo/'.setting('frontend_favicon')).'?'.time() }}" width="20" id="preview-favicon" alt="" />
                                </div>

                                <div class="form-group {{ $errors->has('theme_color') ? ' has-danger' : '' }}">
                                    <label for="example-theme_color-input" class="form-control-label">{{__('labels.theme_color') }}</label>
                                      <input class="form-control" name="theme_color" type="text" value="{{ old('theme_color', setting('theme_color')) }}" id="example-theme_color-input">

                                      @if ($errors->has('theme_color'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('theme_color') }}</strong>
                                        </span>
                                    @endif

                                </div>

                                <div class="form-group {{ $errors->has('theme_color_dark') ? ' has-danger' : '' }}">
                                    <label for="example-theme_color_dark-input" class="form-control-label">{{__('labels.theme_color_dark') }}</label>
                                      <input class="form-control" name="theme_color_dark" type="text" value="{{ old('theme_color_dark', setting('theme_color_dark')) }}" id="example-theme_color_dark-input">

                                      @if ($errors->has('theme_color_dark'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('theme_color_dark') }}</strong>
                                        </span>
                                    @endif

                                </div>

                                <div class="form-group {{ $errors->has('popular_categories') ? ' has-danger' : '' }}">
                                    <label for="example-popular_categories-input" class="form-control-label">{{__('labels.popular_cat') }}</label>
                                      <select name="popular_categories[]" id="input-popular_categories" class="form-control" data-toggle="select" multiple>
                                        <?php $kb_categories  =   \App\Models\KbCategory::all(); ?>
                                        @foreach($kb_categories as $category)
                                            <option value="{{ $category->id }}" {{ in_array($category->id, json_decode(setting('popular_categories')) ) ? 'selected' :'' }}>{{$category->name}}</option>
                                        @endforeach
                                    </select>


                                      @if ($errors->has('popular_categories'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('popular_categories') }}</strong>
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
                <!-- Home Page -->
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{__('labels.home_page') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('settings.frontend.home.store') }}" id="my-form" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('post')

                            <div class="pl-lg-4">


                                <div class="form-group">
                                    <label class="form-control-label" for="frontend_home_header">{{__('labels.header_image') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="frontend_home_header" id="frontend_home_header" lang="en">
                                        <label class="custom-file-label text-left" for="frontend_home_header"><i data-feather="upload" width="15"></i> {{__('labels.select_file') }}</label>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <img src="{{ asset('uploads/'.setting('frontend_home_header')).'?'.time() }}" width="200px" id="preview-frontend_home_header" alt="" />
                                </div>

                                <div class="form-group {{ $errors->has('home_max_articles') ? ' has-danger' : '' }}">
                                    <label for="example-home_max_articles-input" class="form-control-label">{{__('labels.number_recent_posts') }}</label>
                                      <input class="form-control" name="home_max_articles" type="number" value="{{ old('home_max_articles', setting('home_max_articles')) }}" id="example-home_max_articles-input" minlength="1">


                                      @if ($errors->has('home_max_articles'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('home_max_articles') }}</strong>
                                        </span>
                                    @endif

                                </div>

                                <div class="form-group {{ $errors->has('home_featured_categories') ? ' has-danger' : '' }}">
                                    <label for="example-home_featured_categories-input" class="form-control-label">{{__('labels.popular_cat') }}</label>
                                    <select name="home_featured_categories[]" id="input-home_featured_categories" class="form-control" data-toggle="select" multiple>
                                        <?php $kb_categories  =   \App\Models\KbCategory::orderBy('name', 'asc')->get(); ?>
                                        @foreach($kb_categories as $category)
                                            <option value="{{ $category->id }}" {{ in_array($category->id, json_decode(setting('home_featured_categories')) ) ? 'selected' :'' }}>{{$category->name}}</option>
                                        @endforeach
                                    </select>


                                    @if ($errors->has('home_featured_categories'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('home_featured_categories') }}</strong>
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

            });

            $('#upload_image').on('change', (e) => {
                preview_image(e);
            });
            $('#upload_image_favicon').on('change', (e) => {
                preview_image(e, 'preview-favicon');
            });
            $('#frontend_dark_logo').on('change', (e) => {
                preview_image(e, 'preview-frontend_dark_logo');
            });
            $('#frontend_home_header').on('change', (e) => {
                preview_image(e, 'preview-frontend_home_header');
            });

            let themeColor = setColorPicker('#example-theme_color-input', document.querySelector('#example-theme_color-input').value);
            let themeColorDark = setColorPicker('#example-theme_color_dark-input', document.querySelector('#example-theme_color_dark-input').value);
            

        </script>
        @endpush
