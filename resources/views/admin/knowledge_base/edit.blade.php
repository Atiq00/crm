@extends('admin.layouts.app', [ 'current_page' => 'kb' ])

@section('content')

<style>
    /*div.dataTables_wrapper div.dataTables_filter{
        text-align: left;
    }

    div.dataTables_length{
        text-align: right;
    }*/
</style>

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('knowledge_bases.index') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="arrow-left" stroke-width="3" width="12"></i> {{ __('labels.knowledge_bases') }}</a>
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' => __('labels.knowledge_bases')])
    
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.edit_kb') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('knowledge_bases.update', $kb->id) }}" id="my-form" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <div class="pl-lg-4">

                                <div class="form-group{{ $errors->has('sub_category_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-sub_category_id">{{ __('labels.category') }}</label>

                                    <?php
                                        $request_category = !empty(old('sub_category_id')) ? explode('_', old('sub_category_id')) : [ $kb->category_id, $kb->sub_category_id ];
                                        $category = $request_category[0];
                                        $sub_category = isset($request_category[1]) ? $request_category[1] : 0 ;
                                    ?>

                                    {!! html_select_kb_categories(
                                                            $kb_categories, // data
                                                            'sub_category_id',  // name
                                                            '', // CustomAttr,
                                                            true, // isRequired
                                                            $category,  // Selected Category 
                                                            $sub_category // Selected Sub Category 
                                                    ) !!}

                                    @if ($errors->has('sub_category_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('sub_category_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-title">{{ __('labels.title') }}</label>
                                    <input type="text" name="title" id="input-title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.title') }}" value="{{ old('title', $kb->title) }}" required autofocus>

                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="kb-description">{{ __('labels.description') }}</label>

                                    <textarea name="description" id="kb-description" rows="6" class="form-control {{ $errors->has('description', $kb->description) ? ' is-invalid' : '' }}" placeholder="{{ __('labels.description') }}" required>{{ old('description', $kb->description) }}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-active">{{ __('labels.status') }}</label>

                                    <select name="active" id="input-active" class="form-control select2-select {{ $errors->has('title') ? ' is-invalid' : '' }}" required>
                                        <option value="1" {{ old('active', $kb->active)=='1' ? 'selected' :'' }}>{{ __('labels.status_active') }}</option>
                                        <option value="0" {{ old('active', $kb->active)=='0' ? 'selected' :'' }} >{{ __('labels.status_draft') }}</option>
                                    </select>

                                    @if ($errors->has('active'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('active') }}</strong>
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
<script src="{{ asset('admin') }}/vendor/ckeditor/ckeditor.js"></script>
<script>
    $(document).ready(() => {
        CKEDITOR.replace('kb-description', {
            height: 260,
            width: "100%",
            filebrowserUploadUrl: '{{route('ckeditor.image-upload', ['_token' => csrf_token() ])}}',
            filebrowserUploadMethod:  "form"
        });
    });
</script>
@endpush
