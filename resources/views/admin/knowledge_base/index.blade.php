@extends('admin.layouts.app', [ 'current_page' => 'kb' ])

@section('content')

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
            @can('kb.create')
                <a href="{{ route('knowledge_bases.create') }}" class="btn btn-sm btn-icon btn-neutral">
                    <i data-feather="plus" stroke-width="3" width="12"></i> {{ __('labels.new_kb') }}</a>
            @endcan
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' => __('labels.knowledge_bases')])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-4">
                                <h3 class="mb-0 py-2">{{ __('labels.manage_knowledge_bases') }}</h3>
                            </div>
                            <div class="col-12 col-md-8">
                                <!-- Filter Buttons -->

                                <form id="filter-form" action="{{ url()->current() }}" method="GET">
                                    
                                    <div class="row">
                                        <div class="col-12 col-md"></div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group mb-0 py-2 text-left">
                                                {!! html_select_kb_categories(
                                                            $kb_categories, // data
                                                            'category', // name
                                                            'onchange="$(this).parents(\'form\').submit()"', // CustomAttr
                                                            false, // isRequired
                                                            (  isset($category->id) ? $category->id : 'all' ),  // Selected Category 
                                                            (  isset($sub_category->id) ? $sub_category->id : false )  // Selected Sub Category 
                                                    ) !!}
                                            </div>
                                        </div>
                                    </div>

                                </form>

                                

                            </div>
                        </div>

                    </div>

                    <div class="table-responsive pb-3">
                        <table class="table align-items-center table-flush" id="basic-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('labels.id') }}</th>
                                    <th scope="col">{{ __('labels.title') }}</th>
                                    <th scope="col">{{ __('labels.category') }}</th>
                                    <th scope="col">{{ __('labels.status') }}</th>
                                    <th scope="col">{{ __('labels.created_at') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($knowledge_bases as $knowledge_base)
                                    
                                    <tr>
                                        <td>
                                            <a href="{{ route('knowledge_bases.edit', $knowledge_base->id) }}">{{$knowledge_base->id}}</a>
                                        </td>
                                        <td class="table-user">
                                            <b class="pl-3">{{ $knowledge_base->title }}</b>
                                        </td>
                                        <td>
                                            @if( $knowledge_base->sub_category_id > 0 )
                                                <a href="#">{{$knowledge_base->sub_category->category->name}}</a>
                                                 &nbsp;
                                                <span class="text-muted"><i class="fa fa-angle-right"></i></span>
                                                 &nbsp; 
                                                 <a href="#">{{ $knowledge_base->sub_category->name }}</a>
                                            @else
                                                <a href="#">{{$knowledge_base->category->name}}</a>
                                             @endif
                                        </td>
                                        <td>{!! $knowledge_base->active ? '<span class="badge badge-primary">' . __('published') . '</span>' : '<span class="badge badge-secondary">' . __('status_draft') . '</span>'; !!}</td>
                                        <td>{{ $knowledge_base->created_at->format( setting('date_format') )}}</td>
                                        <td class="text-right">

                                            <!-- <a class="btn btn-sm btn-info" href="#!">
                                                <i data-feather="edit-2" width="14"></i> Edit
                                            </a> -->

                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#!" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    @can('kb.edit')
                                                        <a class="dropdown-item" href="{{ route('knowledge_bases.edit', $knowledge_base->id) }}">{{ __('labels.edit') }}</a>
                                                    @endcan
                                                    @can('kb.delete')
                                                        <a class="dropdown-item delete-btn" href="#" onclick="if(confirm('{{ __('labels.confirm_delete') }}')){ $('#FORM_DELETE').attr('action', '{{ route('knowledge_bases.destroy', $knowledge_base->id) }}').submit(); }" >{{ __('labels.delete') }}</a>
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
