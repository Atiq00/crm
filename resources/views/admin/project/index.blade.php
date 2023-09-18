@extends('admin.layouts.app', [ 'current_page' => 'projects' ])

@section('content')


    @include('admin.layouts.headers.cards', ['title' => 'Projects'])

    <div class="container-fluid mt--6">
         
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ "Manage Projects" }}</h3>
                            </div>
                            <div class="col-2 pull-right"></div>
                            <div class="col-2 float-right">
                                <a href="{{route('projects.create')}}" class="float-right"><h4 class="mb-0 btn btn-info pull-right">Create Project</h4></a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive pb-3">
                        <table class="table align-items-center" id="basic-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('labels.id') }}</th>
                                    <th scope="col">Project Name</th>
                                    <th scope="col">Product ID</th>
                                    <th scope="col">Client</th>
                                    <th scope="col">Client Code</th>
                                    <th scope="col">Campaign</th>
                                    <th scope="col">{{ __('labels.created_at') }}</th>                                    
                                    <th scope="col">Active/Enabled</th> 
                                    <th scope="col">Action</th> 
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($projects as $project)
                                    
                                    <tr>
                                        <td>
                                            <a href="{{ route('projects.edit', $project->id) }}">{{$project->id}}</a>
                                        </td>
                                        <td class="table-user">
                                            {{ $project->name }}
                                        </td>
                                        <td class="table-user">
                                            {{ @$project->project_code }}
                                        </td>
                                        <td class="table-user">
                                            {{ (@$project->client) ? @$project->client->name:'' }}
                                        </td>
                                        <td class="table-user">
                                            {{ (@$project->client) ? @$project->client->client_code:'' }}
                                        </td>
                                        <td class="table-user">
                                            {{ (@$project->client->campaign) ? @$project->client->campaign->name:'' }}
                                        </td>
                                        <td>{{$project->created_at}}</td>
                                        <td class="text-right">
                                            <!-- Default checked -->
                                            <div class="custom-control custom-switch">
                                                <input onchange="changeStatus({{$project->id}},this)" type="checkbox" 
													   class="custom-control-input" id="{{ $project->id }}" 
													   @if($project->deleted_at==null ||$project->deleted_at=='' ) 
												       checked @endif>
                                                <label class="custom-control-label" for="{{ $project->id }}"> </label>
                                            </div>
                                        </td>
                                        
                                        
                                        <td  >
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#!" role="button" 
												   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    @can('projects.edit')
                                                        <a class="dropdown-item" href="{{ route('projects.edit', $project->id) }}">
															{{ __('labels.edit') }}</a>
                                                    @endcan
                                                   @can('projects.delete')
														<a class="dropdown-item delete-btn" href="#" 
															onclick="if(confirm('{{ __('labels.confirm_delete') }}')){
																	$('#FORM_DELETE').attr('action', '{{ route('projects.destroy',
																	$project->id) }}').submit(); }" >{{ __('labels.delete') }}</a>
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
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
        <script>
            
                $('#basic-datatable').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ], 
                        paging:false
                    }
                ); 
 
            function changeStatus(id,obj){  
                var val=0;
                if(obj.checked==true)
                    var val=1; 
				$.ajax({
					url: "{{url('api/changeStatus')}}",
					type: "get", 
					data: { 
						'isFixed':val,
						'id':id,   
						'table':"sale_mortgages",
					} ,
					success: function (response) {   
						 $.notify({ 
							message: 'Status Change Succeesfully',
							icon: 'ni ni-check-bold',
						  },{ 
							type: 'success',
							offset: 50,
						  });
					},

				});			
            }
        </script>

        <form action="#" method="post" id="FORM_DELETE">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
        @endpush
