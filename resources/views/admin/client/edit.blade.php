@extends('admin.layouts.app', [ 'current_page' => 'clients' ])

@section('content')

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('clients.index') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="arrow-left" stroke-width="3" width="12"></i> {{__('labels.clients')}}</a>
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' => __('labels.manage_clients')])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">

                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.edit_client') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('clients.update', $client->id) }}" id="my-form" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('labels.name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.name') }}" value="{{ old('name', $client->name) }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('client_code') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">Product ID</label>
                                    <input type="text" disabled name="client_code" id="client_code" class="form-control {{ $errors->has('client_code') ? ' is-invalid' : '' }}" placeholder="Product ID" value="{{ old('client_code',$client->client_code) }}" required autofocus>
                
                                    @if ($errors->has('client_code'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('client_code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                



                                <div class="form-group{{ $errors->has('campaign') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-campaign">{{ __('labels.default_assigned_campaign') }}</label>
                                    <select name="campaign_id" id="input-campaign" class="form-control" data-toggle="select">
                                        <option value="" {{ old('campaign_id', $client->campaign_id) == '' ? 'selected' : '' }}>Select Campaign</option>
                                        @foreach($campaigns as $campaign)
                                            <option value="{{ $campaign->id }}" {{ old('campaign_id', $client->campaign_id)==$campaign->id ? 'selected' :'' }}>{{$campaign->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('campaign_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('campaign_id') }}</strong>
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
