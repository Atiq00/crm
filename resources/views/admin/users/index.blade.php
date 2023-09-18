@extends('admin.layouts.app', [ 'current_page' => 'users' ])

@section('content')

<style>
    /*div.dataTables_wrapper div.dataTables_filter{
        text-align: left;
    }

    div.dataTables_length{
        text-align: right;
    }*/
</style>

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('users.create') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="plus" stroke-width="3" width="12"></i> {{ __('labels.new_user') }}</a>
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' => __('labels.users')])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.manage_users') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive pb-3">
                        <table class="table align-items-center table-flush" id="basic-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">HRMSID</th>
                                    <th scope="col">{{ __('labels.name') }}</th>
                                    <th scope="col">Pseudo Name</th>
                                    <th scope="col">{{ __('labels.email') }}</th>
                                    <th scope="col">Campaign</th>                                    
                                    <th scope="col">Designation</th>                                    
									<th scope="col">ReportingTo</th>

                                    <th scope="col">{{ __('labels.role') }}</th>
                                    <th scope="col">{{ __('labels.created_at') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($users as $user)
                                    
                                    <tr>
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}">{{$user->HRMSID}}</a>
                                        </td>
                                        <td class="table-user">
                                            <img alt="Image placeholder" src="{{ asset('uploads/user/'.$user->image) }}" class="avatar avatar-sm rounded-circle profile-user-image">
                                            <b class="pl-3">{{ $user->name }}</b>
                                        </td>
                                        <td>
                                            <a href="#">{{$user->pseudo_name}}</a>
                                        </td>
                                        <td>
                                            <a href="mailto:{{$user->email}}">{{$user->email}}</a>
                                        </td>
                                        <td>
                                            <a href="#">{{$user->campaign}}</a>
                                        </td>
                                        <td>
                                            <a href="#">{{$user->designation}}</a>
                                        </td>
										<td>
                                            <a href="#">{{$user->reporting_to_id}}</a>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ @$user->roles->first()->name }}</span>
                                        </td>
                                        <td>{{$user->created_at}}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#!" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    @can('users.edit')
                                                        <a class="dropdown-item" href="{{ route('users.edit', $user->id) }}">{{ __('labels.edit') }}</a>
                                                    @endcan
                                                    @can('users.delete')
                                                        <a class="dropdown-item delete-btn" href="#" onclick="if(confirm('{{ __('labels.confirm_delete') }}')){  $('#FORM_DELETE').attr('action', '{{ route('users.destroy', $user->id) }}').submit(); }" >{{ __('labels.delete') }}</a>
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
