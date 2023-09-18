@extends('admin.layouts.app', [ 'current_page' => 'canned_messages' ])

@section('content')

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('canned_messages.index') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="arrow-left" stroke-width="3" width="12"></i> {{ __('labels.canned_messages') }}</a>
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' => __('labels.manage_canned_messages')])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">

                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.edit_canned_messages') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('canned_messages.update', $canned_message->id) }}" id="my-form" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-title">{{ __('labels.title') }}</label>
                                    <input type="text" name="title" id="input-title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.title') }}" value="{{ old('title', $canned_message->title) }}" required autofocus>

                                    @if ($errors->has('tiitle'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tiitle') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('message') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-message">{{ __('labels.message') }}</label>
                                    <textarea name="message" id="input-message" class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.message') }}" rows="9" required>{{ old('message', $canned_message->message) }}</textarea>

                                    @if ($errors->has('message'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('message') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-public">{{ __('labels.status') }}</label>

                                    <select name="public" id="input-public" class="form-control select2-select {{ $errors->has('title') ? ' is-invalid' : '' }}" required>
                                        <option value="0" {{ old('public', $canned_message->public)=='0' ? 'selected' :'' }}>Private</option>
                                        <option value="1" {{ old('public', $canned_message->public)=='1' ? 'selected' :'' }} >Public</option>
                                    </select>

                                    @if ($errors->has('public'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('public') }}</strong>
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
