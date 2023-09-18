@extends('frontend.layouts.app', ['body_class' => 'bg-default', 'nav_class' => 'navbar-theme'])

@section('content')

<div class="container mt-5">

<div class="row">
  <div class="col">

      <div class="card shadow bg-white mt-4">

            <!-- Card header -->
            <div class="card-header bg-white border-0">
              <div class="row">
                <div class="col-12 col-md-6 mt-2">
                  <h4 class="mb-0">#{{ $ticket->id }} {{ $ticket->title }} </h4>
                  {!!front_status_label($ticket->status)!!}
                  <label for="" class="badge badge-pill badge-outline"  title="{{ $ticket->created_at }}">{{ $ticket->created_at->diffForHumans() }}</label>
                </div>
                <div class="col-12 col-md-6 mt-2 text-right">

                  @if($ticket->status=='open' && setting('CUSTOMER_CLOSE_TICKET')=='yes')
                    <a href="{{route('customer.ticket_update_status', [$ticket->id, 'closed'])}}" class="btn btn-primary  btn-icon">
                      <i data-feather="check" width="15"></i>
                      {{ __('frontend.close_ticket') }}
                    </a>
                  @endif
                  @if($ticket->status=='closed' && setting('USER_REOPEN_ISSUE')=='yes')
                    <a href="{{route('customer.ticket_update_status', [$ticket->id, 'reopen'])}}" class="btn btn-danger btn-icon">
                      <i data-feather="refresh-ccw" width="15"></i> {{ __('frontend.reopen_ticket') }}
                    </a>
                  @endif

                    <a href="{{route('customer.tickets')}}" class="btn btn-secondary btn-icon">
                      <i class="ni ni-support-16"></i>
                      {{ __('frontend.all_tickets') }}
                    </a>
                </div>
              </div>
              
            </div>
            <div class="card-body">

              <div class="ticket-view-replies">

                <div class="row">
                  <div class="col">

                    @foreach($ticket->replies as $reply )
                    
                    <div class="ticket-view-reply mt-4">

                      @if(!empty($reply->user_id))

                        <div class="media align-items-center">
                          <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('uploads/user/'.$reply->user->image) }}">
                          </span>
                          <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm font-weight-bold"> &nbsp; {{ $reply->user->name }} </span>
                          </div>
                        </div>

                      @elseif(!empty($reply->customer_id))

                        <div class="media align-items-center">
                          <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('uploads/customer/'.$reply->customer->image) }}">
                          </span>
                          <div class="media-body  ml-2  d-none d-lg-block">
                            <span class="mb-0 text-sm font-weight-bold"> &nbsp; {{ $reply->customer->name }} </span>
                          </div>
                        </div>

                      @endif

                      
                      <div class="ticket-description py-3 pl-3 mt-3 b-1 bg-white">
                        <div class="py-2">{{ $reply->message }}</div>
                        <hr class="my-3">
                        <ul class="list-unstyled list-inline">
                            @foreach($reply->attachments as $file)
                              <li class="py-2 d-block text-secondary btn-link"><a href="{{ url('uploads/reply_attachments/'.$file) }}" target="_blank" class="text-gray"> <i data-feather="download" width="15"></i> &nbsp;&nbsp; {{ $file }}</a></li>                              
                            @endforeach
                        </ul>
                        <small class="comment-date text-muted " title="{{$reply->created_at->format( setting('datetime_format'))}}">
                          {{ $reply->created_at->diffForHumans() }}
                        </small>
                      </div>
                    </div>

                    @endforeach


                  </div>
                </div>
                
              </div>

            </div>

            <div class="card-footer bg-white py-4">
              @if($ticket->status!='closed')
                @include('customer-panel.tickets.partials.reply_form')
              @else
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {!! __('frontend.ticket_is_closed_message') !!}
                      
                    </div>
              @endif

            </div>


      </div>

  </div>
</div>



</div>

@endsection


@push('js')

<script>
  
if ( document.getElementById('my-form') ) {
  $("#my-form").parsley({
     errorClass: 'is-invalid text-danger',
     // successClass: 'is-valid',
     errorsWrapper: '<span class="form-text text-danger"></span>',
     errorTemplate: '<span></span>',
     trigger: 'change',
     errorsContainer: function(el) {
          return el.$element.closest('.form-group');
      },
   });
}
</script>

@endpush
