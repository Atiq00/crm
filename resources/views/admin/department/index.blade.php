@extends('admin.layouts.app', [ 'current_page' => 'departments' ])

@section('content')


    @include('admin.layouts.headers.cards', ['title' => __('labels.departments')])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.manage_departments') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive pb-3">
                        <table class="table align-items-center table-flush" id="basic-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('labels.id') }}</th>
                                    <th scope="col">{{ __('labels.name') }}</th>
                                    <th scope="col">{{ __('labels.created_at') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($departments as $department)
                                    
                                    <tr>
                                        <td>
                                            <a href="{{ route('departments.edit', $department->id) }}">{{$department->id}}</a>
                                        </td>
                                        <td class="table-user">
                                            {{ $department->name }}
                                        </td>
                                        <td>{{$department->created_at->format( setting('date_format') )}}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#!" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    @can('department.edit')
                                                        <a class="dropdown-item" href="{{ route('departments.edit', $department->id) }}">{{ __('labels.edit') }}</a>
                                                    @endcan
                                                    @can('department.delete')
                                                        <a class="dropdown-item delete-btn" href="#" onclick="if(confirm('{{ __('labels.confirm_delete') }}')){  $('#FORM_DELETE').attr('action', '{{ route('departments.destroy', $department->id) }}').submit(); }" >{{ __('labels.delete') }}</a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            {{ __('labels.no_data_found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <div class="col-4">
                @can('department.create')
                    @include('admin.department.partials.add_new_form')
                @endcan
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
