<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col-8">
                <h3 class="mb-0">{{ __('labels.canned_messages') }}</h3>
            </div>
        </div>
    </div>

    <div class="card-body">
        <form method="post" action="{{ route('canned_messages.store') }}" id="my-form" autocomplete="off">
            @csrf
            @method('post')

            <div class="pl-lg-4">
                <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-title">{{ __('labels.title') }}</label>
                    <input type="text" name="title" id="input-title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.title') }}" value="{{ old('title') }}" required autofocus>

                    @if ($errors->has('tiitle'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('tiitle') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('message') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-message">{{ __('labels.message') }}</label>
                    <textarea name="message" id="input-message" class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.message') }}" rows="9" required>{{ old('message') }}</textarea>

                    @if ($errors->has('message'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('message') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-public">{{ __('labels.status') }}</label>

                    <select name="public" id="input-public" class="form-control select2-select {{ $errors->has('title') ? ' is-invalid' : '' }}" required>
                        <option value="0" {{ old('public')=='0' ? 'selected' :'' }}>{{ __('labels.private') }}</option>
                        <option value="1" {{ old('public')=='1' ? 'selected' :'' }} >{{ __('labels.public') }}</option>
                    </select>

                    @if ($errors->has('public'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('public') }}</strong>
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