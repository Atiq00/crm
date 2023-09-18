@extends('admin.layouts.app', [ 'current_page' => 'customers' ])

@section('content')

    @push('header-buttons')
        @can('customer.create')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('customers.create') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="plus" stroke-width="3" width="12"></i> {{ __('labels.new_customer') }}</a>
        </div>
        @endcan
    @endpush

    @include('admin.layouts.headers.cards', ['title' => __('labels.customers') ])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.manage_customer') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive pb-3">
                        <table class="table align-items-center table-flush" id="basic-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('labels.id') }}</th>
                                    <th scope="col">{{ __('labels.name') }}</th>
                                    <th scope="col">{{ __('labels.email') }}</th>
                                    <th scope="col">{{ __('labels.created_at') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($customers as $customer)
                                    
                                    <tr>
                                        <td>
                                            <a href="{{ route('customers.edit', $customer->id) }}">{{$customer->id}}</a>
                                        </td>
                                        <td class="table-user">
                                            <img alt="Image placeholder" src="{{ asset('uploads/customer/'.$customer->image) }}" class="avatar avatar-sm rounded-circle profile-customer-image">
                                            <b class="pl-3">{{ $customer->name }}</b>
                                        </td>
                                        <td>
                                            <a href="mailto:{{$customer->email}}">{{$customer->email}}</a>
                                        </td>
                                        <td>{{$customer->created_at->format( setting('date_format') )}}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#!" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                        @can('customer.edit')
                                                            <a class="dropdown-item" href="{{ route('customers.edit', $customer->id) }}">{{ __('labels.edit') }}</a>
                                                        @endcan
                                                        @can('customer.delete')
                                                            <a class="dropdown-item delete-btn" href="#" onclick="if(confirm('{{ __('labels.confirm_delete') }}')){  $('#FORM_DELETE').attr('action', '{{ route('customers.destroy', $customer->id) }}').submit(); }" >{{ __('labels.delete') }}</a>
                                                        @endcan
                                                </div>
                                            </div>
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
