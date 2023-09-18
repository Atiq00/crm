@extends('admin.layouts.app', [ 'current_page' => 'solar' ])

@section('content')
    @include('admin.layouts.headers.cards', ['title' => "Solar Sol"])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <form action="{{route('austinphoenix_salesheet')}}" method="GET">
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
										@if( auth()->user()->hasRole('Solar Manager') || auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('AllSaleSheets'))
 
                                        <div class="col-md-3 col-lg-2 form-group">
                                            <label>Reporting To</label>
                                            <select name="reporting_to" id="reporting_to"  class="form-control">
                                                <option value="">--Select--</option>                                                 
                                                <option value="521297">Talha Ur Rehman</option> 
                                                <option value="350479">Ali Munawar</option> 
                                                <option value="709111">Yawwar Mehboob</option>                                                 
                                                <option value="333333">Ali Haider Kiyani</option>                                                 
                                                <option value="467959">Arslan Gohar</option>                                                 
                                            </select>                                             
                                        </div>
                                        <div class="col-md-3 col-lg-2 form-group">
                                            <label>Agents</label>
                                            <select name="user_id" id="user_id"  class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($users as $user)
                                                @php  
                                                if(is_int($user->HRMSID))
                                                continue;
                                                    $select='';
                                                    if(@$_GET['user_id'] == $user->HRMSID)
                                                        $select="selected";
                                                    else
                                                    $select="";

                                                @endphp
                                                <option  {{$select}} value="{{$user->HRMSID}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>                                             
                                        </div>  
                                        @endif
                                        @if(auth()->user()->hasRole('Super Admin'))
                                        <div class="col-md-1 col-lg-1 form-group">
                                            <label>&nbsp;</label>
                                            <input type="submit" name="export"  value="export" class="form-control btn btn-primary">                                             
                                        </div>
                                        @endif

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
                                <h3 class="mb-0">Manage Solar Sol Campaigns</h3>
                            </div>
							@if(auth()->user()->hasRole('SolarAgent') || auth()->user()->hasRole('Super Admin'))
                            <div class="col-2 ">
                                <a href="{{route('austinphoenix.create')}}" class="btn btn-info float-right">Sale Submission</a>
                            </div>
							@endif
                        </div>
                    </div>
                    <div class="table-responsive pb-3">
                        <table class="table align-items-center table-flush" id="myTable" > 
                            <thead class="thead-light">
                                <tr>
                                     <th scope="col" width="3%">Serial ID</th>
                                     <th scope="col" width="3%">Record ID</th>
                                     <th scope="col" width="3%">Created At</th>
                                    <th scope="col" width="3%">First Name</th>
									<th scope="col" width="3%">Last Name</th>
                                    @if( auth()->user()->hasRole('Solar Manager') || auth()->user()->hasRole('Mortgage Manager or Solar Manager') || auth()->user()->hasRole('EDDY AND SOLAR MANAGER')  )
                                    <th scope="col" width="3%">Phone</th>
                                    @endif
                                    
                                    <th scope="col">Phone</th>
                                   
                                    @if(auth()->user()->hasRole('SolarClient'))
                                    <th scope="col" width="3%">Phone</th>
                                    @endif
                                    <th scope="col" width="3%">State</th> 
                                    <th scope="col" width="3%">Agent Name</th>
                                    {{-- <th scope="col" width="3%">Pseudonym</th> --}}
                                    <th scope="col" width="3%">Agent HRMSID</th>
									<th scope="col" width="3%">Reporting To</th>
									<th scope="col" width="3%">Client status</th>									
									<th scope="col" width="3%">QA status</th>
                                    <th scope="col" width="3%">Client</th>
                                    <th scope="col" width="3%">Appt Date</th>
									<th scope="col" width="3%">Project</th>
									@if(auth()->user()->hasRole('SolarClient') || auth()->user()->hasRole('Super Admin'))
									<th scope="col" width="10%">Client Status</th> 
									@endif
                                    <th scope="col" width="3%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count=1;?>
                                @foreach($solars as $row)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{$row->record_id}}</td>
                                        <td>{{$row->created_at}}</td>
                                        <td>{{$row->first_name}} </td> 
										<td>{{$row->last_name}}</td> 
                                        @if(auth()->user()->hasRole('Solar Manager') || auth()->user()->hasRole('Mortgage Manager or Solar Manager') || auth()->user()->hasRole('EDDY AND SOLAR MANAGER'))
                                        <td>{{substr($row->phone, 0, 3) }}***{{ substr($row->phone,-4) }}</td>
                                        @endif
                                        @if(auth()->user()->hasRole('Super Admin'))
                                        <td>{{$row->phone}}</td> 
                                        @endif
                                      
                                        <td>{{$row->phone}}</td> 
                                        
                                        <td>{{$row->state}}</td> 
                                        
                                        <td>{{($row->user) ? $row->user->name:'' }}</td>
                                        {{-- <td>{{($row->user) ? $row->user->pseudo_name:'' }}</td>  --}}
                                        <td>{{($row->user) ? $row->user->HRMSID:'' }}</td>
										 <td>{{ $row->user->reporting_to_name ?? '' }}</td>
										<td>{{$row->client_status}}</td>
										<td>{{$row->qa_status}}</td>
                                        <td><b> {{($row->client) ? $row->client->name:'' }} </b></td>
                                        <td>{{$row->app_date_time}}</td>
										<td><b> {{($row->project) ? $row->project->name:'' }} </b></td>
										@if(auth()->user()->hasRole('SolarClient') || auth()->user()->hasRole('Super Admin'))
											<?php $status = ['billable'=>"Accepeted",'not-billable'=>"Rejected" ,'pending'=>"Pending"];?>
											<td> 
												<select onchange="remarks(this.value,{{$row->id}})" class="form-control bg bg-default">
													@foreach($status as $key=> $st)
														<option 
															@if($key==$row->client_status) 
															{{'selected'}} 
															@endif
															@if( $row->client_status !="pending") 
															{{'disabled'}} 
															@endif
															value="{{$key}}">{{ ($st)}}</option>
													@endforeach
												</select>
											</td>
										 
										@endif
                                        <td>
                                            
                                            <a href="#" >
                                                {{-- <i class="fas fa-trash"></i> --}}
                                                <form action="{{route('solars.destroy',[$row->id])}}" method="post">
                                                    <a href="{{route('solars.show',[$row->id])}}" class="btn btn-success btn-sm">View</a>                                                     @if (in_array(Auth::user()->roles[0]->name, ['Super Admin']))
                             						<input class="btn btn-default btn-sm" value="Delete" type="submit"  />
                                                    {!! method_field('delete') !!}
                                                    {!! csrf_field() !!}
                        						@endif
                                                    
                                                </form>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="padding: 22px;">
                            {{$solars->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div id="remarks" class="modal fade" runat="server"  role="dialog">
		  <div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header"> 
				<h4 class="modal-title">Remarks</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			  </div>
			  <div class="modal-body">
				<input type="hidden" id="qa_status">				
				<input type="hidden" id="id_status">

				<label class="lable">Enter Remarks</label>
				<input type="text" class="form-control" id="remarksValue">
			  </div>
			  <div class="modal-footer">          
				<button type="button" class="btn btn-info" onclick="changeStatus()" id="submitRemarks" data-dismiss="modal">Submit</button>				
				<button type="button" class="btn btn-danger" id="dissmiss" data-dismiss="modal">No</button> 	  
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
            order: [[3, 'desc']],
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
