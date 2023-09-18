@extends('admin.layouts.app', [ 'current_page' => 'priorities' ])

@section('content')

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('priorities.index') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="arrow-left" stroke-width="3" width="12"></i> {{ __('labels.priority') }}</a>
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' => __('labels.manage_priority')])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">

                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.edit_priority') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('priorities.update', $priority->id) }}" id="my-form" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('labels.name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" onkeyup="$('#badge-preview').text(this.value)" value="{{ old('name', $priority->name) }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('color') ? ' has-danger' : '' }}">
                                    <label for="example-color-input" class="form-control-label">{{ __('labels.color') }}</label>
                                      <input class="form-control" name="color" type="text" value="{{ old('color', $priority->color) }}" id="example-color-input">
                                </div>

                                <div class="form-group {{ $errors->has('color_text') ? ' has-danger' : '' }}">
                                    <label for="color-text-input" class="form-control-label">{{ __('labels.color_text') }}</label>
                                      <input class="form-control" name="color_text" type="text" value="old('color_text', $priority->color_text)" id="color-text-input">
                                </div>

                                <div class="form-group">
                                    <label for="" class="form-control-label">{{ __('labels.preview') }} : </label>
                                    <div>
                                        <span class="badge badge-pill" id="badge-preview" style="background-color: {{old('color', $priority->color)}}; color: {{old('color_text', $priority->color_text)}};">{{old('name', $priority->name)}}</span>
                                    </div>
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
    let backgroundColor = setColorPicker('#example-color-input', document.querySelector('#example-color-input').value);
    let colortext = setColorPicker('#color-text-input', document.querySelector('#color-text-input').value);

    backgroundColor.on('change', (color, instance) => {
        $('#badge-preview').css('background-color', color.toRGBA().toString(0));
    });

    colortext.on('change', (color, instance) => {
        $('#badge-preview').css('color', color.toRGBA().toString(0));
    });
    backgroundColor.trigger('change');
    colortext.trigger('change');

</script>
@endpush