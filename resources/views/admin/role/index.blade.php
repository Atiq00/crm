@extends('admin.layouts.app', [ 'current_page' => 'roles' ])

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
            @can('role.create')
              <a href="{{ route('roles.create') }}" class="btn btn-sm btn-icon btn-neutral">
                <i data-feather="plus" stroke-width="3" width="12"></i> {{ __('labels.new_role') }}</a>
            @endcan
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' => __('labels.roles') ])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.manage_roles') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive pb-3">
                        <table class="table align-items-center table-flush" id="basic-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('labels.id') }}</th>
                                    <th scope="col">{{ __('labels.name') }}</th>
                                    <th scope="col">{{ __('labels.users') }}</th>
                                    <th scope="col">{{ __('labels.permissions') }}</th>
                                    <th scope="col">{{ __('labels.created_at') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($roles as $role)

                                    <tr>
                                        <td>
                                            <a href="{{ route('roles.edit', $role->id) }}">{{$role->id}}</a>
                                        </td>
                                        <td class="table-role">
                                            <b class="pl-3">{{ $role->name }}</b>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $role->users->count() }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $role->permissions->count() }}</span>
                                        </td>
                                        <td>{{$role->created_at->format( setting('date_format') )}}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#!" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    @can('role.edit')
                                                    
                                                        <a class="dropdown-item" href="{{ route('roles.edit', $role->id) }}">{{ __('labels.edit') }}</a>
                                                        @endcan
                                                        @can('role.delete')
                                                        @if(!in_array($role->id, [1,2]))
                                                            <a class="dropdown-item delete-btn" href="#" onclick="if( !confirm('Are you sure you want to delete this role ? \nNote : All related users & permissions will be also deleted !') )  return false; else  
                                                                $('#FORM_DELETE').attr('action', '{{ route('roles.destroy', $role->id) }}').submit();
                                                            " >{{ __('labels.delete') }}</a>
                                                        @endif
                                                        @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="6">
                                            {{ __('No Roles found') }}
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
