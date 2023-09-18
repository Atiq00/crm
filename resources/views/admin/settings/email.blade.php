@extends('admin.layouts.app', [ 'current_page' => 'email_settings' ])

@section('content')

<style>
    /*div.dataTables_wrapper div.dataTables_filter{
        text-align: left;
    }

    div.dataTables_length{
        text-align: right;
    }*/
</style>

    @include('admin.layouts.headers.cards', ['title' => __('labels.email_settings')])

    <!-- <a href="{{ route('settings.email.sendtestmail') }}" class="btn btn-primary">{{ __('labels.sendtestmail') }}</a> -->
    
    
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-3">
                @include('admin.settings.partials.sidebar', ['settingSidebarActive' => 'email'])
            </div>
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{__('labels.send_email_when') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('settings.email.whentosend') }}" id="my-form" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('post')

                                <div class="form-group{{ $errors->has('EMAIL_USER_TICKET_CREATE_CUSTOMER') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-EMAIL_USER_TICKET_CREATE_CUSTOMER">{{__('labels.when_user_creates_ticket_customer') }}</label><br>

                                    <label class="custom-toggle">
                                        <input type="checkbox" {{ old('EMAIL_USER_TICKET_CREATE_CUSTOMER', setting('EMAIL_USER_TICKET_CREATE_CUSTOMER'))=='yes'?'checked':'' }} name="EMAIL_USER_TICKET_CREATE_CUSTOMER" value="yes">
                                        <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('labels.no') }}" data-label-on="{{__('labels.yes') }}"></span>
                                      </label>                                    

                                    @if ($errors->has('EMAIL_USER_TICKET_CREATE_CUSTOMER'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('EMAIL_USER_TICKET_CREATE_CUSTOMER') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('EMAIL_USER_TICKET_CREATE_AGENT') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-EMAIL_USER_TICKET_CREATE_AGENT">{{__('labels.when_user_creates_ticket_agent') }}</label><br>

                                    <label class="custom-toggle">
                                        <input type="checkbox" {{ old('EMAIL_USER_TICKET_CREATE_AGENT', setting('EMAIL_USER_TICKET_CREATE_AGENT'))=='yes'?'checked':'' }} name="EMAIL_USER_TICKET_CREATE_AGENT" value="yes">
                                        <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('labels.no') }}" data-label-on="{{__('labels.yes') }}"></span>
                                      </label>                                    

                                    @if ($errors->has('EMAIL_USER_TICKET_CREATE_AGENT'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('EMAIL_USER_TICKET_CREATE_AGENT') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('EMAIL_TICKET_CUSTOMER_REPLIED') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-EMAIL_TICKET_CUSTOMER_REPLIED">{{__('labels.when_customer_reply_to_ticket') }}</label><br>

                                    <label class="custom-toggle">
                                        <input type="checkbox" {{ old('EMAIL_TICKET_CUSTOMER_REPLIED', setting('EMAIL_TICKET_CUSTOMER_REPLIED'))=='yes'?'checked':'' }} name="EMAIL_TICKET_CUSTOMER_REPLIED" value="yes">
                                        <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('labels.no') }}" data-label-on="{{__('labels.yes') }}"></span>
                                      </label>                                    

                                    @if ($errors->has('EMAIL_TICKET_CUSTOMER_REPLIED'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('EMAIL_TICKET_CUSTOMER_REPLIED') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('EMAIL_TICKET_AGENT_REPLIED') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-EMAIL_TICKET_AGENT_REPLIED">{{__('labels.when_agent_reply_to_ticket') }}</label><br>

                                    <label class="custom-toggle">
                                        <input type="checkbox" {{ old('EMAIL_TICKET_AGENT_REPLIED', setting('EMAIL_TICKET_AGENT_REPLIED'))=='yes'?'checked':'' }} name="EMAIL_TICKET_AGENT_REPLIED" value="yes">
                                        <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('labels.no') }}" data-label-on="{{__('labels.yes') }}"></span>
                                      </label>                                    

                                    @if ($errors->has('EMAIL_TICKET_AGENT_REPLIED'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('EMAIL_TICKET_AGENT_REPLIED') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="text-left">
                                    <button type="submit" class="btn btn-info mt-4">{{__('labels.update') }}</button>
                                </div>

                        </form>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{__('labels.sendtestmail') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('settings.email.sendtestmail') }}" id="my-form" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('post')

                            <div class="row">
                                <div class="form-group col-md-6 {{ $errors->has('email') ? ' has-danger' : '' }}">
                                      <input class="form-control" name="email" placeholder="{{ __('labels.email') }}" type="email" value="{{ old('email', setting('email')) }}" id="example-email-input">

                                      @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-6 {{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <button type="submit" class="btn btn-primary">{{ __('labels.sendtestmail') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{__('labels.email_settings') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('settings.email.store') }}" id="my-form" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('post')

                            <div class="pl-lg-4">

                                <div class="form-group {{ $errors->has('mail_driver') ? ' has-danger' : '' }}">
                                    <label for="example-mail_driver-input" class="form-control-label">{{__('labels.mail_driver') }}</label>
                                    <select name="mail_driver" id="input-mail_driver" class="form-control" required>
                                        @foreach(['smtp' => 'SMTP', 'sendmail' => 'Sendmail'] as $key => $lang)
                                            <option value="{{ $key }}" {{ old('mail_driver', setting('mail_driver'))==$key ? 'selected' :'' }}>{{$lang}}</option>
                                        @endforeach
                                    </select>

                                      @if ($errors->has('mail_driver'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mail_driver') }}</strong>
                                        </span>
                                    @endif

                                </div>

                                <div class="form-group {{ $errors->has('mail_host') ? ' has-danger' : '' }}">
                                    <label for="example-mail_host-input" class="form-control-label">{{__('labels.mail_host') }}</label>
                                      <input class="form-control" name="mail_host" type="text" value="{{ old('mail_host', setting('mail_host')) }}" id="example-mail_host-input">

                                      @if ($errors->has('mail_host'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mail_host') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('mail_port') ? ' has-danger' : '' }}">
                                    <label for="example-mail_port-input" class="form-control-label">{{__('labels.mail_port') }}</label>
                                      <input class="form-control" name="mail_port" type="number" value="{{ old('mail_port', setting('mail_port')) }}" id="example-mail_port-input">

                                      @if ($errors->has('mail_port'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mail_port') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('mail_username') ? ' has-danger' : '' }}">
                                    <label for="example-mail_username-input" class="form-control-label">{{__('labels.mail_username') }}</label>
                                      <input class="form-control" name="mail_username" type="text" value="{{ old('mail_username', setting('mail_username')) }}" id="example-mail_username-input">

                                      @if ($errors->has('mail_username'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mail_username') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('mail_password') ? ' has-danger' : '' }}">
                                    <label for="example-mail_password-input" class="form-control-label">{{__('labels.mail_password') }}</label>
                                      <input class="form-control" name="mail_password" type="text" value="{{ old('mail_password', setting('mail_password')) }}" id="example-mail_password-input">

                                      @if ($errors->has('mail_password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mail_password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('mail_encryption') ? ' has-danger' : '' }}">
                                    <label for="example-mail_encryption-input" class="form-control-label">{{__('labels.mail_encryption') }}</label>
                                      <input class="form-control" name="mail_encryption" type="text" value="{{ old('mail_encryption', setting('mail_encryption')) }}" id="example-mail_encryption-input">

                                      @if ($errors->has('mail_encryption'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mail_encryption') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('mail_from_name') ? ' has-danger' : '' }}">
                                    <label for="example-mail_from_name-input" class="form-control-label">{{__('labels.mail_from_name') }}</label>
                                      <input class="form-control" name="mail_from_name" type="text" value="{{ old('mail_from_name', setting('mail_from_name')) }}" id="example-mail_from_name-input">

                                      @if ($errors->has('mail_from_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mail_from_name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('mail_from_address') ? ' has-danger' : '' }}">
                                    <label for="example-mail_from_address-input" class="form-control-label">{{__('labels.mail_from_email') }}</label>
                                      <input class="form-control" name="mail_from_address" type="email" value="{{ old('mail_from_address', setting('mail_from_address')) }}" id="example-mail_from_address-input">

                                      @if ($errors->has('mail_from_address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mail_from_address') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="text-left">
                                    <button type="submit" class="btn btn-info mt-4">{{__('labels.update') }}</button>
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

        <script src="{{ asset('admin') }}/vendor/dropzone/dist/min/dropzone.min.js"></script>

        <script>
            $(document).ready(() => {

            });

            let themeColor = setColorPicker('#example-theme_color-input', document.querySelector('#example-theme_color-input').value);


        </script>
        @endpush
