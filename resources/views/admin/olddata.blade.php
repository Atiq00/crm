@extends('admin.layouts.app', [ 'current_page' => 'OLD Data' ])

@section('content')
    @include('admin.layouts.headers.cards', ['title' => "OLD Data"])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <form action="{{route('solars.index')}}" method="GET">
                                    <div class="row">
                                        <div class="col-md-2 col-lg-2 form-group">
                                            <label>Phone</label>
                                            <input type="text" value="{{@$_GET['search']}}" name="search" class="form-control">                                             
                                        </div>
                                        <div class="col-md-2 col-lg-2 form-group">
                                            <label>From Date</label>
                                            <input type="date" value="{{@$_GET['start_date']}}"  name="start_date" class="form-control">                                             
                                        </div>
                                        <div class="col-md-2 col-lg-2 form-group">
                                            <label>To Date</label>
                                            <input type="date" value="{{@$_GET['end_date']}}"  name="end_date" class="form-control">                                             
                                        </div> 

                                        <div class="col-md-1 col-lg-1 form-group">
                                            <label>&nbsp;</label>
                                            <input type="submit" name="submit"  value="search" class="form-control btn btn-primary">                                             
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>                             
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-10">
                                <h3 class="mb-0">Manage Solar Campaigns</h3>
                            </div>
							@if(auth()->user()->hasRole('SolarAgent') || auth()->user()->hasRole('Super Admin'))
                            <div class="col-2 ">
                                <a href="{{route('solars.create')}}" class="btn btn-info float-right">Sale Submission</a>
                            </div>
							@endif
                        </div>
                    </div>
                    <div class="table-responsive pb-3"><tr style="background: lightblue;"> 
                                
                        <table class="table align-items-center table-flush" id="myTable" > 
                            
                            <thead class="thead-light"><tr>
                                    <td> <b>Total Count</b></td> 
                                    <td id="Hours"><b>{{@$data->total()}} </b></td>
                                </tr>
                                <tr>
                                     <th scope="col" width="3%">Serial ID</th>
                                     <th scope="col" width="3%">Record ID</th>
                                     <th scope="col" width="3%">Created At</th>
                                    <th scope="col" width="3%">First Name</th>
									<th scope="col" width="3%">Last Name</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count=1;?>
                                @foreach($data as $key=> $row)
                                    <tr>
                                        <td>{{ $data->firstItem()+$key }}</td>
                                        <td>{{@$row->record_id}}</td>
                                        <td>{{@$row->created_at}}</td> 
                                        <td>{{@$row->first_name}} </td> 
										<td>{{@$row->last_name}}</td>  
                                         
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="padding: 22px;">
                            {{$data->appends($_GET)->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        @include('admin.layouts.footers.auth')
    </div>
@endsection

    @push('js')
        
        <script>
        $('#myTable').DataTable({
            order: [[0, 'asc']],
            paging:false
        });
			function remarks(val,id){
				$('#remarks').modal('show');
				document.getElementById('id_status').value=id;				
				document.getElementById('qa_status').value=val;

			}
            function selectClient(val){
                $.ajax({
                    url:"{{url('api/selectClient')}}",
                    type:"get",
                    data:{
                        "client_id":val
                    },
                    success:function(res){
                        var options="";
                        for(let i=0;i<res.length;i++){
                            options +="<option value="+ res[i].project_code+">"+res[i].name+"</option>";
                        }
                        console.log(options);
                        document.getElementById('project_id').innerHTML=options

                    }
                });
            }
			function changeStatus(){
				
				let id=document.getElementById('id_status').value;				
				let val=document.getElementById('qa_status').value;
				let remarks=document.getElementById('remarksValue').value;
				$.ajax({
					url: "{{url('api/changeStatusClient')}}",
					type: "get", 
					data: { 
						'client_status':val,
						'id':id,  
						'remarks':remarks,
						'table':"sale_records",
					} ,
					success: function (response) {  
						 document.getElementById('id_status').value='';				
						 document.getElementById('qa_status').value='';
						 document.getElementById('remarks').value='';
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
            $(document).ready(() => {

                $('#basic-datatable').DataTable();
            });
        </script>

        <form action="#" method="post" id="FORM_DELETE">
            @csrf
            @method('DELETE')
        </form>
@endpush
