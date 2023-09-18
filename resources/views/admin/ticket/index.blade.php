@extends('admin.layouts.app', [ 'current_page' => 'tickets' ])

@section('content')

    @push('header-buttons')
        @can('ticket.create')
            <div class="col-lg-6 col-5 text-right">
              <a href="{{ route('tickets.create') }}" class="btn btn-sm btn-icon btn-neutral">
                <i data-feather="plus" stroke-width="3" width="12"></i> {{ __('labels.new_ticket') }}</a>
            </div>
        @endcan
    @endpush

    @include('admin.layouts.headers.cards', ['title' => __('labels.tickets')])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <h3 class="mb-0">{{ __('labels.manage_tickets') }}</h3>
                            </div>
                            <div class="col-8">
                                <!-- Filter Buttons -->

                                <form id="filter-form" action="{{ url()->current() }}" method="GET">
                                    
                                    <div class="row">
                                        <div class="col"></div>
                                        <div class="col-2">
                                            <div class="form-group text-center">
                                                <select name="sort" id="sort" class="select2-select" onchange="$(this).parents('form').submit()">
                                                    <option value="latest" {{ request()->sort == 'latest' ? 'selected' : '' }}>{{ __('labels.latest') }}</option>
                                                    <option value="oldest" {{ request()->sort == 'oldest' ? 'selected' : '' }}>{{ __('labels.oldest') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </form>

                                

                            </div>
                        </div>
                    </div>

                    <div class="table-responsive pb-3">
                        <table class="table align-items-center table-flush" id="basic-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">
                                        <div class="custom-control custom-checkbox">
                                          <input type="checkbox" class="custom-control-input" id="customCheckAll">
                                          <label class="custom-control-label" for="customCheckAll"></label>
                                        </div>
                                    </th>
                                    <th scope="col">{{ __('labels.id') }}</th>
                                    <th scope="col">{{ __('labels.title') }}</th>
                                    <th scope="col">{{ __('labels.customer') }}</th>
                                    <th scope="col">{{ __('labels.user') }}</th>
                                    <th scope="col">{{ __('labels.department') }}</th>
                                    <th scope="col">{{ __('labels.priority') }}</th>
                                    <th scope="col">{{ __('labels.status') }}</th>
                                    <th scope="col">{{ __('labels.reply_status') }}</th>
                                    <th scope="col">{{ __('labels.last_update') }}</th>
                                    <th scope="col">{{ __('labels.created_at') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($tickets as $i => $ticket)
                                    
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                              <input type="checkbox" class="custom-control-input checkbox-tickets-select" id="customCheck{{$i}}" value="{{$ticket->id}}">
                                              <label class="custom-control-label" for="customCheck{{$i}}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('tickets.show', $ticket->id) }}">{{$ticket->id}}</a>
                                        </td>
                                        <td class="table-user">
                                            <a href="{{ route('tickets.show', $ticket->id) }}" class="text-gray-dark"><b class="pl-3">{{ $ticket->title }}</b></a>
                                        </td>
                                        <td>
                                            <img alt="Image placeholder" src="{{ asset('uploads/customer/'.@$ticket->customer->image) }}" class="avatar avatar-sm rounded-circle profile-user-image">
                                            <span class="pl-3">{{ @$ticket->customer->name }}</span>
                                        </td>
                                        <td>
                                            @if($ticket->user_id > 0 && !empty($ticket->user))
                                                <img alt="Image placeholder" src="{{ asset('uploads/user/'.@$ticket->user->image) }}" class="avatar avatar-sm rounded-circle profile-user-image">
                                                <span class="pl-3">{{ @$ticket->user->name }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{$ticket->department->name}}
                                        </td>
                                        <td>
                                            {!! priority_label($ticket->priority) !!}
                                        </td>
                                        <td>
                                            {!! status_label($ticket->status) !!}
                                        </td>
                                        <td>
                                            {!! reply_status_label($ticket->status_reply) !!}
                                        </td>
                                        <td>
                                            <span title="{{ $ticket->updated_at->format( setting('datetime_format') ) }}">{{$ticket->updated_at->diffForHumans()}}</span>
                                        </td>
                                        <td>
                                            <span title="{{ $ticket->created_at->format( setting('datetime_format') ) }}">{{$ticket->created_at->format( setting('date_format') )}}</span>
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#!" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                        @can('ticket.reply_ticket')
                                                            <a class="dropdown-item" href="{{ route('tickets.show', $ticket->id) }}">{{ __('labels.view_reply') }}</a>
                                                        @endcan
                                                        @can('ticket.assign_user')
                                                            <a class="dropdown-item" href="#" onclick="$('#assign_user_ticket_ids').val({{$ticket->id}})" data-toggle="modal" data-target="#modal-assign-user-ticket-form">{{ __('labels.assign_user') }}</a>
                                                        @endcan
                                                        @can('ticket.edit')
                                                            <a class="dropdown-item" href="{{ route('tickets.edit', $ticket->id) }}">{{ __('labels.edit') }}</a>
                                                        @endcan
                                                        @can('ticket.delete')
                                                            <a class="dropdown-item delete-btn" href="#" onclick="if(confirm('{{ __('labels.confirm_delete') }}')){  $('#FORM_DELETE').attr('action', '{{ route('tickets.destroy', $ticket->id) }}').submit(); }" >{{ __('labels.delete') }}</a>
                                                        @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">
                                            {{ __('labels.no_data_found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body">
                        @canany([ 'ticket.edit', 'ticket.delete' ])
                          <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="ticketWithSelected">{{ __('labels.with_selected') }}</button>
                                <div class="dropdown-menu">
                                @can('ticket.edit')
                                  <a class="dropdown-item text-primary" href="#" onclick="assignMultipleUsers(); return false;"><i class="fa fa-user"></i> &nbsp;{{ __('labels.assign_user') }}</a>
                                @endcan
                                @can('ticket.delete')
                              <a class="dropdown-item text-primary" href="#" onclick="deleteTickets(); return false;"><i class="fa fa-trash"></i> &nbsp;{{ __('labels.delete') }}</a>
                                @endcan
                            </div>
                          </div><!-- /btn-group -->
                        @endcanany
                    </div>

                </div>
            </div>
        </div>

        @include('admin.layouts.footers.auth')

        @can('ticket.edit')
            @include('admin.ticket.modal_assign_user')
        @endcan



    </div>
@endsection


        @push('js')

        <script>
            $(document).ready(() => {

                $('#basic-datatable').DataTable();

                $('#customCheckAll').on('change', function() {
                    $('.checkbox-tickets-select').prop('checked', $(this).is(':checked')).trigger('change');
                    ticketCheckUpdateFunc();
                });

                $('.checkbox-tickets-select').on('change', function() {

                    if($(this).is(':checked'))
                        $(this).parents('tr').addClass('bg-secondary');
                    else
                        $(this).parents('tr').removeClass('bg-secondary');

                    if(!$(this).is(':checked')){
                        $('#customCheckAll').prop('checked', false);
                    }
                    ticketCheckUpdateFunc();
                });


                window.ticketCheckUpdateFunc = () => {

                    var isAnyChecked = false;

                    $('.checkbox-tickets-select').each(function() {
                        if($(this).is(':checked')){
                            isAnyChecked = true;
                            return false;
                        }
                    });

                    $('#ticketWithSelected').prop('disabled', !isAnyChecked);

                };

                ticketCheckUpdateFunc();

            });

            window.assignMultipleUsers = () => {
                let values = $('.checkbox-tickets-select:checked').map(function() {return parseInt(this.value);}).get().join(',');

                $('#assign_user_ticket_ids').val(values);
                $('#modal-assign-user-ticket-form').modal('show');
            };

            window.deleteTickets = () => {

                if(!confirm('Are you want to delete the selected tickets ?'))
                    return false;

                let values = $('.checkbox-tickets-select:checked').map(function() {return parseInt(this.value);}).get().join(',');

                $('#FORM_MULTI_DELETE').find('input[name=ticket_ids]').val(values);
                $('#FORM_MULTI_DELETE').attr('action', '{{ route('tickets.destroy_multiple') }}').submit();

            };


            /**
             * Filters
             */
            $('select.select2-select').select2({
                minimumResultsForSearch: -1
            });

        </script>

        <form action="#" method="post" id="FORM_DELETE">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

            <form action="#" method="post" id="FORM_MULTI_DELETE">
                @csrf
                @method('DELETE')
                <input type="hidden" name="ticket_ids" value="0" />
            </form>

        @endpush
