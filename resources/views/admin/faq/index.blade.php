@extends('admin.layouts.app', [ 'current_page' => 'faq' ])

@section('content')

    @push('header-buttons')
        @can('faq.create')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('faqs.create') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="plus" stroke-width="3" width="12"></i> {{ __('labels.new_faq') }}</a>
        </div>
        @endcan
    @endpush

    @include('admin.layouts.headers.cards', ['title' => __('labels.faqs')])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.manage_faqs') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive pb-3">
                        <table class="table align-items-center table-flush" id="basic-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('labels.id') }}</th>
                                    <th scope="col">{{ __('labels.question') }}</th>
                                    <th scope="col">{{ __('labels.answer') }}</th>
                                    <th scope="col">{{ __('labels.category') }}</th>
                                    <th scope="col">{{ __('labels.created') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($faqs as $faq)
                                    
                                    <tr>
                                        <td>
                                            <a href="{{ route('faqs.edit', $faq->id) }}">{{$faq->id}}</a>
                                        </td>
                                        <td class="table-user">
                                            <b class="pl-3">{{ $faq->question }}</b>
                                        </td>
                                        <td>
                                        {{ strlen($faq->answer) > 50 ? substr( strip_tags($faq->answer), 0, 50).'...' : $faq->answer  }}
                                        </td>
                                        <td>
                                            {{ $faq->category->name }}
                                        </td>
                                        <td>{{ $faq->created_at->format( setting('date_format') )}}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#!" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    @can('faq.edit')
                                                        <a class="dropdown-item" href="{{ route('faqs.edit', $faq->id) }}">{{ __('labels.edit') }}</a>
                                                    @endcan
                                                    @can('faq.delete')
                                                        <a class="dropdown-item delete-btn" href="#" onclick="if(confirm('{{ __('labels.confirm_delete') }}')){  $('#FORM_DELETE').attr('action', '{{ route('faqs.destroy', $faq->id) }}').submit(); }" >{{ __('labels.delete') }}</a>
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
