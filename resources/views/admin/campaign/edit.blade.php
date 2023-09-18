@extends('admin.layouts.app', [ 'current_page' => 'campaigns' ])

@section('content')

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('campaigns.index') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="arrow-left" stroke-width="3" width="12"></i> {{__('labels.campaigns')}}</a>
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' => __('labels.manage_campaigns')])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">

                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.edit_campaign') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('campaigns.update', $campaign->id) }}" id="my-form" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('labels.name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.name') }}" value="{{ old('name', $campaign->name) }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>



                                <div class="form-group{{ $errors->has('user') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-user">{{ __('labels.default_assigned_user') }}</label>
                                    <select name="assigned_user_id" id="input-user" class="form-control" data-toggle="select">
                                        <option value="" {{ old('assigned_user_id', $campaign->assigned_user_id) == '' ? 'selected' : '' }}>Select User</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('assigned_user_id', $campaign->assigned_user_id)==$user->id ? 'selected' :'' }}>{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('assigned_user_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('assigned_user_id') }}</strong>
                                        </span>
                                    @endif
                                    <span class="help-text text-muted" style="font-size: .8rem; font-style: italic;">{{ __('labels.future_tickets_message') }}</span>
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
