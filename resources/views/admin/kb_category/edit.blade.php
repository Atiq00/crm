@extends('admin.layouts.app', [ 'current_page' => 'kb_category' ])

@section('content')

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('kb_categories.index') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="arrow-left" stroke-width="3" width="12"></i> {{__('labels.kb_category')}}</a>
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' => __('labels.kb_category')])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">

                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.edit_kb_category') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('kb_categories.update', $category->id) }}" id="my-form" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="pl-lg-4">
                                
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('labels.name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.name') }}" value="{{ old('name', $category->name) }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>



                                <div class="form-group{{ $errors->has('img_type') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-img">{{ __('labels.icon_type') }}</label>
                                    <select name="img_type" id="img_type" class="form-control" onchange="$('.img-type-wrapper').hide(); $( $(this).find(':selected').val() ).show();">
                                        <option value=".img-file" {{ old('img_type')=='.img-file' ? 'selected' : '' }}>{{ __('labels.file') }}</option>
                                        <option value=".img-url" {{ old('img_type')=='.img-url' ? 'selected' : '' }}>{{ __('labels.url') }}</option>
                                    </select>
                                    @if ($errors->has('img'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('img') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('img') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-img">{{ __('labels.icon') }}</label>
                                    <div class="img-type-wrapper img-file">
                                        <input type="file" name="img" id="input-img" class="form-control {{ $errors->has('img') ? ' is-invalid' : '' }}" value="{{ old('img') }}">
                                        @if ($errors->has('img'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('img') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="img-type-wrapper img-url" style="display: none;">
                                        <input type="text" name="img_url" id="input-img-url" class="form-control {{ $errors->has('img') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.icon_url') }}" value="{{ old('img_url') }}">
                                        @if ($errors->has('img_url'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('img_url') }}</strong>
                                            </span>
                                        @endif
                                        <p class="text-muted" style="font-size: .9rem; font-style: italic;">Shortcodes: {site_url}, {upload_url}, {asset_url}</p>
                                    </div>

                                </div>

                                <div class="form-group{{ $errors->has('img') ? ' has-danger' : '' }}">
                                    <img src="{{decode_icon_url($category->img)}}" width="100" alt="test">
                                </div>


                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-description">{{ __('labels.description') }}</label>

                                    <textarea name="description" id="input-description" rows="6" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('description') }}" required>{{ old('description', $category->description) }}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
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

        <script>
            $(document).ready(() => {

                $('#basic-datatable').DataTable();
            });
        </script>

        <form action="#" method="post" id="FORM_DELETE">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
        @endpush
