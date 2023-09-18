@extends('admin.layouts.app', [ 'current_page' => 'kb' ])

@section('content')

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('knowledge_bases.index') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="arrow-left" stroke-width="3" width="12"></i> {{ __('labels.knowledge_bases') }}</a>
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' => __('labels.knowledge_bases')])
    
<style>
.ck-editor__editable_inline {
    min-height: 250px;
}
</style>
<form method="post" action="{{ route('knowledge_bases.store') }}" id="my-form" autocomplete="off" enctype="multipart/form-data">
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-4">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.new_kb') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                            @csrf
                            @method('post')

                                <div class="form-group{{ $errors->has('sub_category_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-sub_category_id">{{ __('labels.category') }}</label>

                                    <?php
                                        $request_category = explode('_', old('sub_category_id'));
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

                                    <!--select name="sub_category_id" id="input-sub_category_id" class="form-control" required data-toggle="select">
                                        @foreach($kb_categories as $category)
                                            <optgroup label="{{$category->name}}">
                                                @foreach($category->sub_categories as $sub_category)
                                                    <option value="{{ $sub_category->id }}" {{ old('sub_category_id')==$category->id ? 'selected' :'' }}>{{$sub_category->name}}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select-->
                                    @if ($errors->has('sub_category_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('sub_category_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-title">{{ __('labels.title') }}</label>
                                    <input type="text" name="title" id="input-title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.title') }}" value="{{ old('title') }}" required autofocus>

                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-active">{{ __('labels.status') }}</label>

                                    <select name="active" id="input-active" class="form-control select2-select {{ $errors->has('active') ? ' is-invalid' : '' }}" required>
                                        <option value="1" {{ old('active')=='1' ? 'selected' :'' }}>{{ __('labels.status_active') }}</option>
                                        <option value="0" {{ old('active')=='0' ? 'selected' :'' }} >{{ __('labels.status_draft') }}</option>
                                    </select>

                                    @if ($errors->has('active'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('active') }}</strong>
                                        </span>
                                    @endif
                                </div>



                                <div class="text-left">
                                    <button type="submit" class="btn btn-info mt-4">{{ __('labels.submit') }}</button>
                                </div>
                    </div>

                    
                </div>
            </div>

            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.description') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                            <textarea name="description" id="kb-description" rows="12" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" required>{{ old('description') }}</textarea>

                            @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.layouts.footers.auth')



    </div>

                        </form>
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
