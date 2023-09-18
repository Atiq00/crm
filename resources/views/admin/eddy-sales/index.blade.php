@extends('admin.layouts.app', [ 'current_page' => 'users' ])

@section('content') 
    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('eddyuserCreate') }}" class="btn btn-sm btn-icon btn-neutral">
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
                                    <th scope="col">ID</th>
                                    <th scope="col">HRMSID</th>
                                    <th scope="col">Name</th>  
                                    <th scope="col">PseudoName</th>  
                                    <th scope="col">Agent ID</th>         
                                    <th scope="col">Type</th>         
                                    <th scope="col">Project Code</th>         
                                    <th scope="col">Action</th>         
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counter=1;?>
                                @forelse ($users as $user)
                                    
                                    <tr> 
                                        <td>
                                            <a href="#">{{$counter++}}</a>
                                        </td>
                                        <td>
                                            <a href="#">{{$user->HRMSID}}</a>
                                        </td>
                                        <td>
                                            <a href="#">{{$user->name}}</a>
                                        </td>
                                        <td>
                                            <a href="#">{{$user->psedo_name}}</a>
                                        </td>
										<td>
                                            <a href="#">{{$user->agent_name}}</a>
                                        </td>
                                        <td>
                                            <a href="#">{{$user->type}}</a>
                                        </td>
                                        <td>
                                            <a href="#">{{$user->project_code}}</a>
                                        </td>
                                        <td>
                                            <a href="{{route('eddyuserDelete',$user->id)}}"> <i class="fas fa-trash"></i></a>
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
        




        



<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script>
        <script>
            $('#basic-datatable ul').addClass("pagination-sm");
            $(document).ready(() => {
                $('#basic-datatable').DataTable({
                    ordering:true,
                    "pagingType": "simple",
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            });
        </script>

        <form action="#" method="post" id="FORM_DELETE">
            @csrf
            @method('DELETE')
        </form>
        @endpush
