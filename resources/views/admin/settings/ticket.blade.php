@extends('admin.layouts.app', [ 'current_page' => 'ticket_settings' ])

@section('content')

<style>
    /*div.dataTables_wrapper div.dataTables_filter{
        text-align: left;
    }

    div.dataTables_length{
        text-align: right;
    }*/
</style>

    @include('admin.layouts.headers.cards', ['title' => __('labels.ticket_settings')])
    
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-3">
                @include('admin.settings.partials.sidebar', ['settingSidebarActive' => 'ticket'])
            </div>
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{__('labels.ticket_settings') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('settings.ticket.store') }}" id="my-form" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('post')

                            <div class="pl-lg-4">

                                <div class="form-group{{ $errors->has('auto_assign_user') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-auto_assign_user">{{__('labels.auto_assign_user') }}</label><br>

                                    <label class="custom-toggle">
                                        <input type="checkbox" {{ old('auto_assign_user', setting('auto_assign_user'))=='yes'?'checked':'' }} name="auto_assign_user" value="yes">
                                        <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('labels.no') }}" data-label-on="{{__('labels.yes') }}"></span>
                                    </label>                                    

                                    @if ($errors->has('auto_assign_user'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('auto_assign_user') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('ticket_default_assigned_user_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-ticket_default_assigned_user_id">{{__('labels.default_assigned_user') }}</label>
                                    <select name="ticket_default_assigned_user_id" id="input-user" class="form-control" data-toggle="select">
                                        @foreach(\App\User::get() as $user)
                                            <option value="{{ $user->id }}" {{ old('ticket_default_assigned_user_id', setting('ticket_default_assigned_user_id'))==$user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach

                                    </select>

                                    @if ($errors->has('ticket_default_assigned_user_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('ticket_default_assigned_user_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('USER_REOPEN_ISSUE') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-USER_REOPEN_ISSUE">{{__('labels.alow_ticket_reopen') }}</label><br>

                                    <label class="custom-toggle">
                                        <input type="checkbox" {{ old('USER_REOPEN_ISSUE', setting('USER_REOPEN_ISSUE'))=='yes'?'checked':'' }} name="USER_REOPEN_ISSUE" value="yes">
                                        <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('labels.no') }}" data-label-on="{{__('labels.yes') }}"></span>
                                      </label>                                    

                                    @if ($errors->has('USER_REOPEN_ISSUE'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('USER_REOPEN_ISSUE') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('CUSTOMER_CLOSE_TICKET') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-CUSTOMER_CLOSE_TICKET">{{__('labels.alow_ticket_close') }}</label><br>

                                    <label class="custom-toggle">
                                        <input type="checkbox" {{ old('CUSTOMER_CLOSE_TICKET', setting('CUSTOMER_CLOSE_TICKET'))=='yes'?'checked':'' }} name="CUSTOMER_CLOSE_TICKET" value="yes">
                                        <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('labels.no') }}" data-label-on="{{__('labels.yes') }}"></span>
                                      </label>                                    

                                    @if ($errors->has('CUSTOMER_CLOSE_TICKET'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('CUSTOMER_CLOSE_TICKET') }}</strong>
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
                $('#basic-datatable').DataTable();
            });
            $('#upload_image').on('change', (e) => {
                preview_image(e);
            });
        </script>
        @endpush
