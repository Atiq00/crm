<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col-8">
                <h3 class="mb-0">{{ __('labels.kb_category') }}</h3>
            </div>
        </div>
    </div>

    <div class="card-body">
        <form method="post" action="{{ route('kb_categories.store') }}" id="my-form" autocomplete="off" enctype="multipart/form-data">
            @csrf
            @method('post')

            <div class="pl-lg-4">

                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-name">{{ __('labels.name') }}</label>
                    <input type="text" name="name" id="input-name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.name') }}" value="{{ old('name') }}" required autofocus>

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
                        <input type="file" name="img" id="input-img" class="form-control {{ $errors->has('img') ? ' is-invalid' : '' }}" value="{{ old('img') }}" autofocus>
                        @if ($errors->has('img'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('img') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="img-type-wrapper img-url" style="display: none;">
                        <input type="text" name="img_url" id="input-img-url" class="form-control {{ $errors->has('img') ? ' is-invalid' : '' }}" placeholder="{{ __('Icon Url') }}" value="{{ old('img_url') }}" autofocus>
                        @if ($errors->has('img_url'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('img_url') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                @if(old('img_type'))
                <script>
                    $('{{old('img_type')}}').show();
                </script>
                @endif

                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-description">{{ __('labels.description') }}</label>

                    <textarea name="description" id="input-description" rows="6" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('description') }}" required>{{ old('description') }}</textarea>

                    @if ($errors->has('description'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="text-left">
                    <button type="submit" class="btn btn-info mt-4">{{ __('labels.submit') }}</button>
                </div>
            </div>

        </form>
    </div>

</div>