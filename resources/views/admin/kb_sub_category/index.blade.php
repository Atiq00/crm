@extends('admin.layouts.app', [ 'current_page' => 'kb_sub_categories' ])

@section('content')


    @include('admin.layouts.headers.cards', ['title' => __('labels.kb_sub_category')])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <h3 class="mb-0">{{ __('labels.kb_sub_category') }}</h3>
                            </div>
                            <div class="col-8">
                                <!-- Filter Buttons -->

                                <form id="filter-form" action="{{ url()->current() }}" method="GET">
                                    
                                    <div class="row">
                                        <div class="col"></div>
                                        <div class="col-4">
                                            <div class="form-group text-left">
                                                <select name="category" id="category" class="select2-select" data-toggle="select" onchange="$(this).parents('form').submit()">
                                                    <option value="all" {{ !request()->has('category') || request()->category == 'all' ? 'selected' : '' }}>All Categories</option>
                                                    @foreach($kb_categories as $category)
                                                        <option value="{{$category->id}}" {{ request()->category == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
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
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Creation Date</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($kb_sub_categories as $kb_sub_category)
                                    
                                    <tr>
                                        <td>
                                            <a href="{{ route('kb_sub_categories.edit', $kb_sub_category->id) }}">{{$kb_sub_category->id}}</a>
                                        </td>
                                        <td class="table-user">
                                            {{ $kb_sub_category->name }}
                                        </td>
                                        <td>
                                            {{ $kb_sub_category->category->name }}
                                        </td>
                                        <td>{{$kb_sub_category->created_at->format( setting('date_format') )}}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#!" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    @can('kb_category.edit')
                                                        <a class="dropdown-item" href="{{ route('kb_sub_categories.edit', $kb_sub_category->id) }}">{{ __('labels.edit') }}</a>
                                                    @endcan
                                                    @can('kb_category.delete')
                                                        <a class="dropdown-item delete-btn" href="#" onclick="if(confirm('{{ __('labels.confirm_delete') }}')){  $('#FORM_DELETE').attr('action', '{{ route('kb_sub_categories.destroy', $kb_sub_category->id) }}').submit(); }" >{{ __('labels.delete') }}</a>
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
                @can('kb_category.delete')
                    @include('admin.kb_sub_category.partials.add_new_form')
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
