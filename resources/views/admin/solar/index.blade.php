@extends('admin.layouts.app', [ 'current_page' => 'solar' ])

@section('content')
    @include('admin.layouts.headers.cards', ['title' => "Solar"])

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
										@if(auth()->user()->hasRole('Mortgage Manager or Solar Manager')  || auth()->user()->hasRole('EDDY AND SOLAR MANAGER') || auth()->user()->hasRole('Solar Manager') || auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('AllSaleSheets') || auth()->user()->HRMSID == 887913 || auth()->user()->HRMSID ==  943739 )
 
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>Reporting To</label>
                                            <select name="reporting_to" id="reporting_to"  class="form-control">
                                                <option value="">--Select--</option>                                                 
                                                <option value="521297">Talha Ur Rehman</option> 
                                                <option value="350479">Ali Munawar</option> 
                                                <option value="617830">Isma Mazhar </option> 
                                                <option value="061720">Sumreen Stephen</option> 
                                                <option value="937501">Jawad Sarfaraz</option> 
                                                <option value="709111">Yawwar Mehboob</option>                                                 
                                                <option value="333333">Ali Haider Kiyani</option>                                                 
                                                <option value="467959">Arslan Gohar</option>                                                 
                                            </select>                                             
                                        </div>
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>Agents</label>
                                            <select name="user_id" id="user_id"  class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($users as $user)
                                                @php   
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
                                        @if( auth()->user()->hasRole('Super Admin'))
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>Client</label>
                                            <select name="client_id" id="" onchange ="selectClient(this.value)"    class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($clients as $client)
                                                @php 
                                                    $select='';
                                                    if(@$_GET['client_id'] == $client->client_code)
                                                        $select="selected";
                                                    else
                                                    $select="";

                                                @endphp
                                                <option {{$select}} value="{{$client->client_code}}">{{$client->name}}</option>
                                                @endforeach
                                            </select>                                             
                                        </div>
                                        @endif
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>Project</label>
                                            <select name="project_id" id="project_id"  class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($projects as $project)
                                                @php 
                                                    $select='';
                                                    if(@$_GET['project_id'] == $project->project_code)
                                                        $select="selected";
                                                    else
                                                    $select="";

                                                @endphp
                                                <option  {{$select}} value="{{$project->project_code}}">{{$project->name}}</option>
                                                @endforeach
                                            </select>                                             
                                        </div>
                                        @endif
                                       
                                        @if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('EDDY AND SOLAR MANAGER') || auth()->user()->hasRole('SolarClient') || auth()->user()->HRMSID == 887913 || auth()->user()->HRMSID ==  943739  )
                                        <div class="col-md-2 col-lg-2 form-group">
                                            <label>&nbsp;</label>
                                            <input type="submit" name="export"  value="export" class="form-control btn-block btn btn-primary">                                             
                                        </div>
                                        @endif

                                        <div class="col-md-2 col-lg-2 form-group">
                                            <label>&nbsp;</label>
                                            <input type="submit" name="submit"  value="search" class="form-control btn btn-primary">                                             
                                        </div>
                                        
                                    </div>
                                </form>
								
								
								
								
								<br><br>
								
								
								
								
								
								
                            </div>                             
                        </div>
                    </div> 
                </div>
            </div>
        </div>
		
		@if( auth()->user()->hasRole('Super Admin') )		
			<div class="row">
				<div class="col">
					<div class="card shadow">					
						<form action="{{ route('UpdateBillableStatus') }}" method="POST" id="webform"
							  enctype="multipart/form-data">
							@csrf
							<div class="row" style="padding:30px">
								<div class="form-group col-md-6">											
									<div class="custom-file">
										<input type="file" class="form-control" id="" name="file">
										<input type="hidden" class="form-control" id="" name="table" value="sale_records">
									</div>
								</div>
								<div class="col-md-3 col-lg-3 form-group">
									<select name="project_id" id="project_id"  class="form-control">
										<option value="">--Select--</option>
										@foreach($projects as $project) 
										<option  value="{{$project->project_code}}">{{$project->name}}</option>
										@endforeach
									</select>                                             
								</div>
								<div class="form-group col-md-3 col-lg-3"> 
									<button type="submit" class="form-control btn btn-info">Update Billable Status</button>
								</div>
							</div>
						</form> 

					</div>
				</div>
			</div>
		@endif
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
                                    <td id="Hours"><b>{{@$solars->total()}} </b></td>
                                </tr>
                                <tr>
                                     <th scope="col" width="3%">Serial ID</th>
                                     <th scope="col" width="3%">Record ID</th>
                                     <th scope="col" width="3%">Created At</th>
                                     <th scope="col" width="3%">pseudonym</th>
                                    <th scope="col" width="3%">First Name</th>
									<th scope="col" width="3%">Last Name</th>
                                    <th scope="col" width="3%">Phone</th> 
                                     
                                    <th scope="col" width="3%">State</th> 
                                    <th scope="col" width="3%">ZipCode</th> 
                                    <th scope="col" width="3%">Agent Name</th>
                                    {{-- <th scope="col" width="3%">Pseudonym</th> --}}
                                    <th scope="col" width="3%">Agent HRMSID</th>
									<th scope="col" width="3%">Reporting To</th>
									<th scope="col" width="3%">Client status</th>									
									<th scope="col" width="3%">QA status</th>
                                    @if(auth()->user()->hasRole('Super Admin')||auth::id(4015))
                                    <th scope="col" width="3%">Client</th>
                                    @endif
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
                                @foreach($solars as $key=> $row)
                                    <tr>
                                        <td>{{ $solars->firstItem()+$key }}</td>
                                        <td>{{$row->record_id}}</td>
                                        <td>{{$row->created_at}}</td>
                                        <td>{{$row->user->pseudo_name ?? ''}}</td>
                                        <td>{{$row->first_name}} </td> 
										<td>{{$row->last_name}}</td> 

                                        @if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('SolarClient' ))
                                            <td>{{$row->phone}} @if($row->project_code == "PRO0033") - {{@$row->posting->leadid}} @endif</td> 
                                        @elseif((auth()->user()->HRMSID == 87223 && $row->project_code == "PRO0033"  ) )
                                            <td>{{$row->phone}} - {{@$row->posting->leadid}}</td> 
                                        @elseif(auth()->user()->HRMSID == 887913 || auth()->user()->HRMSID ==  943739) 
                                        <td>{{$row->phone}} @if($row->project_code == "PRO0033") - {{@$row->posting->leadid}} @endif </td> 
                                        @else
                                            <td>{{substr($row->phone, 0, 3) }}***{{ substr($row->phone,-4) }}</td>  
                                        @endif 
                                        <td>{{$row->state}}</td> 
                                        <td>{{$row->zipcode}}</td> 
                                        
                                        <td>{{($row->user) ? $row->user->name:'' }}</td>
                                        {{-- <td>{{($row->user) ? $row->user->pseudo_name:'' }}</td>  --}}
                                        <td>{{($row->user) ? $row->user->HRMSID:'' }}</td>
										 <td>{{ $row->user->reporting->name ?? '' }}</td>
										<td>{{$row->client_status}}</td>
										<td>{{$row->qa_status}}</td>
                                        @if(auth()->user()->hasRole('Super Admin')||auth::id(4015))
                                        <td><b> {{($row->client) ? $row->client->name:'' }} </b></td>
                                        @endif
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
                            {{$solars->appends($_GET)->links()}}
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
