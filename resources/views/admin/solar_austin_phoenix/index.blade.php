@extends('admin.layouts.app', [ 'current_page' => 'solar' ])

@section('content')
    @include('admin.layouts.headers.cards', ['title' => "Solar SOL"])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <form action="{{route('austinphoenix.index')}}" method="GET">
                                    <div class="row">
                                        <div class="col-md-2 col-lg-2 form-group">
                                            <label>Search</label>
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
                                                                         
                                        @if(auth()->user()->hasRole('Super Admin'))
                                        {{-- <div class="col-md-1 col-lg-1 form-group">
                                            <label>&nbsp;</label>
                                            <input type="submit" name="export"  value="export" class="form-control btn btn-primary">                                             
                                        </div> --}}
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
                                <h3 class="mb-0">Manage SOL Campaigns</h3>
                            </div> 
                            <div class="col-2 ">
                                <a href="{{route('austinphoenix.create')}}" class="btn btn-info float-right">@if(@$GET['record_id'] ) Sales Submission @else Leads From Other SRC @endif</a>
                            </div>
						 
                        </div>
                    </div>
                    <div class="table-responsive pb-3">
                        <table class="table align-items-center table-flush" id="myTable" > 
                            <thead class="thead-light">
                            <tr>                                
                                <th width="5%">RecordID</th>
                                <th width="5%">Name</th> 
                                <th width="5%">Phone</th>
                                <th width="5%">Email</th>
                                <!-- <th width="5%">State</th> -->
                                <th width="5%">Address</th>
                                <th width="5%">City</th>
                                <th width="5%">Zipcode</th>
                                <th>Status</th>
                                <th width="5%">Submission</th>
                                {{-- <th width="5%">Score</th> --}}
                                <th width="5%">Type</th>
                                
                                {{-- <th width="5%">UtilityProvider</th>
                                <th width="5%">Homeowner</th>
                                <th width="5%">AvgBill</th>
                                <th width="5%">Property</th>
                                <th width="5%">CostOnAvg</th>
                                <th width="5%">Date</th>
                                <th width="5%">Msg</th> --}}
                                {{-- <th width="5%">CreatedAt</th> --}}
                            </tr>
                            </thead>
                            <tbody>
                                <?php $count=1;?>
                                @foreach($solars as $row)
                                    <tr>                                         
                                        <td>{{$row->record_id}}</td>
                                        <td>{{$row->first_name}} {{$row->last_name}}</td>                                        
                                        <td>{{$row->phone_number}}</td>
                                        <td>{{$row->email}}</td>
                                        {{--<td>{{$row->state}}</td>--}}
                                        <td>{{$row->street_address}}</td>
                                        <td>{{$row->city}}</td>
                                        <td>{{$row->zip_code}}</td>
                                        <td>
                                            <select @if($row->status) disabled @endif  onchange="changeStatusPci({{$row->id}},this)" style="width: 110px;" class="form-control" name="status" id="">
                                                <option value="">--Select--</option>
                                                <option @if($row->status == "Accept") selected="selected" @endif value="Accept">Accept</option>
                                                <option @if($row->status == "Reject") selected="selected" @endif value="Reject">Reject</option>
                                            </select>
                                        </td>
                                        <td><a class="btn btn-info" href="{{route('austinphoenix.create',['record_id'=>$row->record_id])}}">Create</a></td>
                                        {{-- <td>{{$row->credit_score}}</td> --}}
                                        <td>{{strtoupper($row->type)}}  </td>
                                        
                                        
                                        {{-- <td>{{$row->utility_provider}}</td>
                                        <td>{{$row->home_owner}}</td>
                                        <td>{{$row->avg_monthly_bill}}</td>
                                        <td>{{$row->propery}}</td>
                                        <td>{{$row->cost_on_avg}}</td>
                                        <td>{{$row->date}}</td>
                                        <td>{{$row->msg}}</td> --}}
                                        {{-- <td>{{$row->created_at}}</td> --}}
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
        
            // $('#myTable').DataTable({ 
            //     paging:false
            // }); 
            function changeStatusPci(id,obj){ 		 
                $.ajax({
                    url: "{{url('api/changeStatusPci')}}",
                    type: "get", 
                    data: { 
                        'status':obj.value,
                        'id':id
                    } ,
                    success: function (response) {   
                        $.notify({ 
                            message: 'Status Change Succeesfully',
                            icon: 'ni ni-check-bold',
                        },{ 
                            type: 'success',
                            offset: 50,
                        });
                        if(obj.value=="Reject")
                        obj.parentElement.parentElement.remove()
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
