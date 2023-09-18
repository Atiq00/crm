<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col-8">
                <h3 class="mb-0">{{ __('labels.new_faq_category') }}</h3>
            </div>
        </div>
    </div>

    <div class="card-body">
        <form method="post" action="{{ route('faq-category.store') }}" id="my-form" autocomplete="off">
            @csrf
            @method('post')

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

        </form>
    </div>

</div>