@extends('frontend.layouts.app', ['body_class' => 'bg-default', 'nav_class' => 'navbar-theme'])

@section('content')

<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" />

<div class="container mt-5">

  <div class="row">
    <div class="col">

      <div class="row">
        <div class="col-xl-4 col-md-6">
          <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">{{ __('frontend.all_tickets') }}</h5>
                  <span class="h2 font-weight-bold mb-0">{{ $totalAll }}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                    <i class="ni ni-support-16"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6">
          <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">{{ __('frontend.open') }}</h5>
                  <span class="h2 font-weight-bold mb-0">{{ $totalOpen }}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                    <i class="ni ni-support-16"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6">
          <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">{{ __('frontend.closed') }}</h5>
                  <span class="h2 font-weight-bold mb-0">{{ $totalClosed }}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                    <i class="ni ni-support-16"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

        <div class="card bg-white mt-4">

              <!-- Card header -->
              <div class="card-header bg-white border-0">
                <div class="row">
                  <div class="col-12 col-md-6">
                    <h3 class="mb-0">{{ __('frontend.tickets') }}</h3>
                  </div>
                  <div class="col-12 col-md-6 text-right">
                      <a href="{{route('customer.ticket_new')}}" class="btn btn-primary" data-original-title="" title="">
                      {!! __('frontend.create_ticket') !!}
                        
                      </a>
                  </div>
                </div>
                
              </div>
              <div class="card-body px-0">
                
              <form action="{{ route('customer.tickets.filter', $ticketStatus ) }}" method="GET">
                <div class="row px-3">
                  <div class="col-12 col-md-4">
                    <div class="form-group">
                      <input type="text" name="query" placeholder="Search Title, Description, ID..." class="form-control" value="{{ request('query') }}" />
                    </div>
                  </div>
                  <div class="col-12 col-md-4">
                    <div class="form-group">
                      <button type="submit" class="btn btn-dark">{{ __('labels.search') }}</button>
                    </div>
                  </div>
                </div>
              </form>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                  <li class="nav-item">
                    <a class="nav-link {{ $ticketStatus=='all' ? 'active' :'' }}" href="{{route('customer.tickets.filter', 'all')}}">{{ __('frontend.all_tickets') }}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link {{ $ticketStatus=='open' ? 'active' :'' }}" href="{{route('customer.tickets.filter', 'open')}}">{{ __('frontend.open') }}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link {{ $ticketStatus=='closed' ? 'active' :'' }}" href="{{route('customer.tickets.filter', 'closed')}}">{{ __('frontend.closed') }}</a>
                  </li>
                </ul>
              </div>
              <!-- Light table -->
              <div class="table-responsive">
                <table class="table" id="basic-datatables">
                  <thead>
                      <tr>
                          <th class="text-center">#</th>
                          <th>{{ __('labels.title') }}</th>
                          <th>{{ __('labels.status') }}</th>
                          <th width="20%">{{ __('labels.date') }}</th>
                          <th class="text-right" width="10%"></th>
                      </tr>
                  </thead>
                  <tbody>

                    @foreach($tickets as $ticket)
                      <tr>
                          <td class="text-center"><a href="{{route('customer.tickets_view', $ticket->id)}}"><?php echo $ticket->id ?></a></td>
                          <td width="40%"><a href="{{route('customer.tickets_view', $ticket->id)}}">{{$ticket->title}}</a></td>
                          <td>{!! $ticket->status=='open' ? front_reply_status_label($ticket->status_reply) : front_status_label($ticket->status) !!}</td>
                          <td title="{{$ticket->created_at->format(setting('datetime_format'))}}">{{ $ticket->created_at->diffForHumans() }}</td>
                          <td class="td-actions text-center">
                            <a href="{{route('customer.tickets_view', $ticket->id)}}" rel="tooltip" class="text-primary" data-original-title="" title="">
                              <i data-feather="link" width="17" stroke-width="2"></i>
                              </a>
                          </td>
                      </tr>
                      @endforeach

                  </tbody>
              </table>
              </div>
              <!-- Card footer -->
              <div class="card-footer bg-white py-4">

              {{ $tickets->links('customer-panel.tickets.partials.pagination') }}
                
              </div>

        </div>

    </div>

  </div>

</div>

@endsection


@push('js')


<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script>
  $(document).ready( function () {
    $('#basic-datatables').DataTable({
      "searching":   false,
      "paging":   false,
      "order": [],
      // "ordering": false,
      "info":     false
    });
} );
</script>

@endpush