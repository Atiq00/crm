@extends('admin.layouts.app', [ 'current_page' => 'dashboard' ])

@section('content')
    @include('admin.layouts.headers.cards', [ 'title' => 'Dashboard' ])
    
    
    
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-4 col-md-6">
          <div class="card bg-gradient-info">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total Leads</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">{{$open_tickets}}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-white text-primary rounded-circle shadow">
                    <i class="fa fa-life-ring"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6">
          <div class="card bg-gradient-dark">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total Sales</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">{{$total_tickets}}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                    <i class="fa fa-life-ring"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6">
          <div class="card bg-gradient-success">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0 text-white">Billable Leads</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">{{$unreplied_tickets}}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-white text-success rounded-circle shadow">
                    <i class="fa fa-life-ring"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- <div class="row"  style="position: relative; min-height: 500px;">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">{{ __('labels.latest_tickets') }}</h3>
                </div>
                <div class="col text-right">
                  <a href="<?php echo route('tickets.index') ?>?sort=latest" class="btn btn-sm btn-primary">See all</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <div class="table-responsive">
                <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" class="sort">#</th>
                      <th scope="col" class="sort">{{ __('labels.title') }}</th>
                      <th scope="col" class="sort">{{ __('labels.customer') }}</th>
                      <th scope="col">{{ __('labels.priority') }}</th>
                      <th scope="col">{{ __('labels.status') }}</th>
                      <th scope="col">{{ __('labels.created_at') }}</th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody class="list">
                    @forelse ($latest_tickets as $i => $ticket)
                    <tr>
                      <td class="budget">
                        <?php echo $ticket->id ?>
                      </td>
                      <td class="budget">
                        <?php echo $ticket->title ?>
                      </td>
                      <th scope="row">
                        <div class="media align-items-center">
                          <a href="#" class="avatar rounded-circle mr-3">
                            <img alt="Image placeholder" src="{{ asset('uploads/customer/'.@$ticket->customer->image) }}">
                          </a>
                          <div class="media-body">
                            <span class="name mb-0 text-sm">{{$ticket->customer->name}}</span>
                          </div>
                        </div>
                      </th>
                      <td>
                        {!! priority_label($ticket->priority) !!}
                      </td>
                      <td>
                        {!! status_label($ticket->status) !!}
                      </td>
                      <td title="{{$ticket->created_at->format(setting('datetime_format'))}}">
                        {{ $ticket->created_at->diffForHumans() }}
                      </td>
                      <td class="text-right">
                        <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-sm btn-primary">{{ __('labels.view') }}</a>
                      </td>
                    </tr>
                     @empty
                        <tr>
                            <td colspan="6">
                              {{ __('labels.no_data_found') }}
                            </td>
                        </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div> --}}
      @include('admin.layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('admin') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('admin') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush