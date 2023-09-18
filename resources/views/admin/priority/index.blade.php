@extends('admin.layouts.app', [ 'current_page' => 'priorities' ])

@section('content')


    @include('admin.layouts.headers.cards', ['title' => __('labels.manage_priority')])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.priority') }}</h3>
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
                                    <th scope="col">{{ __('labels.preview') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($priorities as $priority)
                                    
                                    <tr>
                                        <td>
                                            <a href="{{ route('priorities.edit', $priority->id) }}">{{$priority->id}}</a>
                                        </td>
                                        <td class="table-user">
                                            {{ $priority->name }}
                                        </td>
                                        <td>{{$priority->created_at->format( setting('date_format') )}}</td>
                                        <td>{!! priority_label($priority) !!}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#!" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    @can('priority.edit')
                                                        <a class="dropdown-item" href="{{ route('priorities.edit', $priority->id) }}">{{ __('labels.edit') }}</a>
                                                    @endcan
                                                    @can('priority.delete')
                                                        <a class="dropdown-item delete-btn" href="#" onclick="if(confirm('{{ __('labels.confirm_delete') }}')){  $('#FORM_DELETE').attr('action', '{{ route('priorities.destroy', $priority->id) }}').submit(); }" >{{ __('labels.delete') }}</a>
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

            <div class="col-4">
                @can('priority.create')
                    @include('admin.priority.partials.add_new_form')
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
