@extends('admin.layouts.app', [ 'current_page' => 'kb_sub_categories' ])

@section('content')

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('kb_sub_categories.index') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="arrow-left" stroke-width="3" width="12"></i> {{__('labels.kb_sub_category')}}</a>
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' => __('Manage labels.kb_sub_category')])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">

                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.edit_kb_sub_category') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('kb_sub_categories.update', $category->id) }}" id="my-form" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <div class="pl-lg-4">

                                <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-category_id">{{ __('labels.category') }}</label>
                                    <select name="category_id" id="input-category_id" class="form-control" data-toggle="select">
                                        <option value="">--{{__('labels.no_parent')}}--</option>
                                        @foreach($kb_categories as $kbcategory)
                                            <option value="{{ $kbcategory->id }}" {{ old('category_id', $category->category_id)==$kbcategory->id ? 'selected' :'' }}>{{$kbcategory->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('category_id') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('labels.name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.name') }}" value="{{ old('name', $category->name) }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
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
