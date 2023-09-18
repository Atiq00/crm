@extends('admin.layouts.app', [ 'current_page' => 'tickets' ])

@section('content')

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('tickets.index') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="arrow-left" stroke-width="3" width="12"></i> {{ __('labels.tickets') }}</a>
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' => __('labels.view_ticket') ])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-lg-4 col-md-2 order-xs-last">
                <div class="sidebar-ticket-view">
                    <div class="card">
                        <!-- Card body -->
                        <div class="card-header">
                              <!-- Title -->
                              <div class="row align-items-center">
                                <div class="col-6">
                                  <!-- Title -->
                                  <h5 class="h3 mb-0">{{ __('labels.customer') }}</h5>
                                </div>
                                <div class="col-6 text-right">
                                  <!-- <a href="{{ route('users.show', [ 'user' => $ticket->customer->id ]) }}" class="btn btn-sm btn-neutral">Profile</a> -->
                                  <a href="{{ route('tickets.index') }}" class="btn btn-sm btn-neutral">{{ __('labels.tickets') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <!-- Avatar -->
                                    <a href="#" class="avatar avatar-xl rounded-circle">
                                        <img alt="{{$ticket->customer->name}}" src="{{ asset('uploads/customer/'.$ticket->customer->image) }}">
                                    </a>
                                </div>
                                <div class="col ml--2">
                                    <h4 class="mb-0">
                                        <a href="#!">{{$ticket->customer->name}}</a>
                                    </h4>
                                    <p class="text-sm text-muted mb-0">{{$ticket->customer->email}}</p>
                                    <!-- <span class="text-success">●</span>
                                    <small>Active</small> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{ __('labels.details') }}</h3>
                                </div>
                            </div>
                        </div>
                        <table class="table align-items-center table-flush">
                            <tbody class="list">
                                <tr>
                                    <td scope="row" width="30">{{ __('labels.department') }} :</td>
                                    <td><b>{{ $ticket->department->name }}</b></td>
                                </tr>
                                <tr>
                                    <td scope="row" width="30">{{ __('labels.status') }} :</td>
                                    <td><b> {!! status_label($ticket->status) !!} </b></td>
                                </tr>
                                <tr>
                                    <td scope="row" width="30">{{ __('labels.priority') }} :</td>
                                    <td><b> {!! reply_label($ticket->status_reply) !!} </b></td>
                                </tr>
                                <tr>
                                    <td scope="row" width="30">{{ __('labels.last_update') }} :</td>
                                    <td>{{ $ticket->updated_at->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <td scope="row" width="30">{{ __('labels.created_at') }} :</td>
                                    <td>{{ $ticket->created_at->format( setting('date_format') ) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card">
                        <!-- Card body -->
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-6">
                                  <!-- Title -->
                                  <h5 class="h3 mb-0">{{ __('labels.assigned_agent') }}</h5>
                                </div>
                                <div class="col-6 text-right">
                                    @can('ticket.assign_user')
                                      <a href="#!" class="btn btn-sm btn-neutral"  onclick="$('#assign_user_ticket_ids').val({{$ticket->id}})" data-toggle="modal" data-target="#modal-assign-user-ticket-form">{{ __('labels.assign_user') }}</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(!empty($ticket->user))
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <!-- Avatar -->
                                    <a href="#" class="avatar avatar-xl rounded-circle">
                                        <img alt="{{$ticket->name}}" src="{{ asset('uploads/user/'.$ticket->user->image) }}">
                                    </a>
                                </div>
                                <div class="col ml--2">
                                    <h4 class="mb-0">
                                        <a href="#!">{{$ticket->user->name}}</a>
                                    </h4>
                                    <p class="text-sm text-muted mb-0">{{$ticket->user->email}}</p>
                                    <!-- <span class="text-success">●</span>
                                    <small>Active</small> -->
                                </div>
                            </div>
                            @else
                                <div class="text-center">
                                    <div class="alert alert-danger">No Assigned User</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card shadow">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{ __('labels.description') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $ticket->description }}
                        </div>
                    </div>
                </div>

            </div>
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">{{ __('labels.ticket') }} {{ $ticket->title }} #{{ $ticket->id }}</h3>
                            </div>
                            <div class="col text-right">
                                @can('ticket.reply_ticket')
                                    @if($ticket->status=='open')
                                        <a href="{{ route('tickets.close_ticket', $ticket->id) }}" class="btn btn-info btn-sm"><i data-feather="check" width="15"></i> &nbsp;&nbsp;{{ __('labels.close_ticket') }}</a>
                                        <a href="#!" class="btn btn-primary btn-sm" onclick="$('textarea').focus();"><i class="fa fa-reply"></i> &nbsp;&nbsp;{{ __('labels.reply_ticket') }}</a>
                                    @endif
                                    @if($ticket->status=='closed')
                                        <a href="{{ route('tickets.reopen_ticket', $ticket->id) }}" class="btn btn-danger btn-sm"><i data-feather="refresh-ccw" width="15"></i> &nbsp;&nbsp;{{ __('labels.reopen_ticket') }}</a>
                                        <a href="#!" class="btn btn-primary btn-sm disabled" disabled><i class="fa fa-reply"></i> &nbsp;&nbsp;{{ __('labels.reply_ticket') }}</a>
                                    @endif
                                @endcan
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card body -->
                    <div class="card-body p-0 ticket-replies">
                      <!-- List group -->
                      <div class="list-group list-group-flush">

                        @foreach($ticket->replies as $reply)

                        <div class="list-group-item  bg-secondary flex-column align-items-start py-5 px-4">
                          <div class="d-flex w-100 justify-content-between">
                            <div>
                              <div class="d-flex w-100 align-items-center">
                                @if(!empty($reply->user_id))

                                    <img src="{{ asset('uploads/user/'.$reply->user->image) }}" alt="Image placeholder" class="avatar avatar-xs mr-2 rounded-circle" />
                                    <h5 class="mb-1">{{ $reply->user->name }} </h5>

                                @elseif(!empty($reply->customer_id))

                                    <img src="{{ asset('uploads/customer/'.$reply->customer->image) }}" alt="Image placeholder" class="avatar avatar-xs mr-2 rounded-circle" />
                                    <h5 class="mb-1">{{ $reply->customer->name }} </h5>

                                @endif
                              </div>
                            </div>
                            <small>{{ $reply->created_at->diffForHumans() }}</small>
                          </div>
                          <p class="text-sm pt-3 mb-3">{{$reply->message}}</p>
                          <ul class="list-unstyled">
                            @foreach($reply->attachments as $file)
                                <li class="pb-2"><a href="{{ url('uploads/reply_attachments/'.$file) }}" target="_blank" class="text-gray"> <i data-feather="download" width="15"></i> &nbsp;&nbsp; {{ $file }}</a></li>                              
                            @endforeach
                          </ul>
                        </div>

                        @endforeach



                      </div>
                    </div>

                    <div class="card-footer">

                        @if($ticket->status!='closed')
                            @can('ticket.reply_ticket')
                                @include('admin.ticket.partials.reply_form')
                            @endcan
                        @else
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <span class="alert-icon"><i class="ni ni-bell-55"></i></span>
                                <span class="alert-text"> {!! __('labels.ticket_closed_message_admin') !!} </span>
                              </div>
                        @endif

                    </div>
                        
                </div>
            </div>
        </div>

        @include('admin.layouts.footers.auth')



    </div>

    @include('admin.ticket.modal_assign_user', [ 'user_id' => (!empty($ticket->user) ? $ticket->user->id : 0), 'ticket_ids' => $ticket->id ])

@endsection


        @push('js')

        <script>
            $(document).ready(() => {

                $('#basic-datatable').DataTable();

                document.querySelector('.ticket-replies').scrollTop = document.querySelector('.ticket-replies').scrollHeight;

            });
        </script>

        <form action="#" method="post" id="FORM_DELETE">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
        @endpush
