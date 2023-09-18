@extends('admin.layouts.app', [ 'current_page' => 'faq' ])

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
          <a href="{{ route('faqs.index') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="arrow-left" stroke-width="3" width="12"></i> {{ __('labels.faqs') }}</a>
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' => __('labels.faqs')])
    
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.new_faq') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('faqs.store') }}" id="my-form" autocomplete="off">
                            @csrf
                            @method('post')

                            <div class="pl-lg-4">

                                <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-category_id">{{ __('labels.category') }}</label>
                                    <select name="category_id" id="input-category_id" class="form-control" required>
                                        @foreach($faq_categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' :'' }}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('category_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-question">{{ __('labels.question') }}</label>
                                    <input type="text" name="question" id="input-question" class="form-control {{ $errors->has('question') ? ' is-invalid' : '' }}" placeholder="{{ __('Question') }}" value="{{ old('question') }}" required autofocus>

                                    @if ($errors->has('question'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('question') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('answer') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-answer">{{ __('labels.answer') }}</label>

                                    <textarea name="answer" id="input-answer" rows="6" class="form-control {{ $errors->has('answer') ? ' is-invalid' : '' }}" placeholder="{{ __('answer') }}" required>{{ old('answer') }}</textarea>

                                    @if ($errors->has('answer'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('answer') }}</strong>
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
        @endpush
