<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col-8">
                <h3 class="mb-0">{{__('labels.new_client')}}</h3>
            </div>
        </div>
    </div>

    <div class="card-body">
        <form method="post" action="{{ route('clients.store') }}" id="my-form" autocomplete="off">
            @csrf
            @method('post')

            <div class="pl-lg-4">
                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-name">{{ __('labels.name') }}</label>
                    <input type="text" name="name" id="input-name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autofocus>

                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('client_code') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-name">Client Code</label>
                    <input type="text" name="client_code" id="client_code" class="form-control {{ $errors->has('client_code') ? ' is-invalid' : '' }}" placeholder="Client Code" value="{{ old('client_code') }}" required autofocus>

                    @if ($errors->has('client_code'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('client_code') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('campaign') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-campaign">{{ __('labels.default_assigned_campaign') }}</label>
                    <select name="campaign_id" id="input-campaign" class="form-control" data-toggle="select"  required>
                        <option value="">Select Campaign</option>
                        @foreach($campaigns as $campaign)
                            <option value="{{ $campaign->id }}" {{ old('campaign_id')==$campaign->id ? 'selected' :'' }}>{{$campaign->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('campaign_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('campaign_id') }}</strong>
                        </span>
                    @endif
                    <!-- <span class="help-text text-muted" style="font-size: .8rem; font-style: italic;">{{ __('labels.future_tickets_message') }}</span> -->
                </div>

                <div class="text-left">
                    <button type="submit" class="btn btn-info mt-4">{{ __('labels.submit') }}</button>
                </div>
            </div>

        </form>
    </div>

</div>