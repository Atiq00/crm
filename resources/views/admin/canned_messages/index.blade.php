@extends('admin.layouts.app', [ 'current_page' => 'canned_messages' ])

@section('content')


    @include('admin.layouts.headers.cards', ['title' => __('labels.canned_messages')])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.manage_canned_messages') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive pb-3">
                        <table class="table align-items-center table-flush" id="basic-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('labels.id') }}</th>
                                    <th scope="col">{{ __('labels.title') }}</th>
                                    <th scope="col">{{ __('labels.created_at') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($canned_messages as $canned_message)
                                    
                                    <tr>
                                        <td>
                                            <a href="{{ route('canned_messages.edit', $canned_message->id) }}">{{$canned_message->id}}</a>
                                        </td>
                                        <td class="table-user">
                                            {{ $canned_message->title }} 
                                            @if($canned_message->public)
                                                <span class="badge badge-primary">{{ __('labels.public') }}</span>
                                            @endif
                                        </td>
                                        <td>{{$canned_message->created_at->format( setting('date_format') )}}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#!" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                        @can('ticket_canned_messages.edit')
                                                        <a class="dropdown-item" href="{{ route('canned_messages.edit', $canned_message->id) }}">{{ __('labels.edit') }}</a>
                                                        @endcan
                                                        @can('ticket_canned_messages.delete')
                                                        <a class="dropdown-item delete-btn" href="#" onclick="if(confirm('{{ __('labels.confirm_delete') }}')){  $('#FORM_DELETE').attr('action', '{{ route('canned_messages.destroy', $canned_message->id) }}').submit(); }" >{{ __('labels.delete') }}</a>
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
                @can('ticket_canned_messages.create')
                     @include('admin.canned_messages.partials.add_new_form')
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
