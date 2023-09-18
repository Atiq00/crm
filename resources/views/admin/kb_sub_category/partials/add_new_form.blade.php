<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col-8">
                <h3 class="mb-0">{{ __('labels.new_kb_sub_category') }}</h3>
            </div>
        </div>
    </div>

    <div class="card-body">
        <form method="post" action="{{ route('kb_sub_categories.store') }}" id="my-form" autocomplete="off">
            @csrf
            @method('post')

            <div class="pl-lg-4">

                <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-category_id">{{ __('labels.category') }}</label>
                    <select name="category_id" id="input-category_id" class="form-control" data-toggle="select" required>
                        @foreach($kb_categories as $category)
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
                    <label class="form-control-label" for="input-name">{{ __('labels.name') }}</label>
                    <input type="text" name="name" id="input-name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.name') }}" value="{{ old('name') }}" required autofocus>

                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
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