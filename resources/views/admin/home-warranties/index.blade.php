@extends('admin.layouts.app', ['current_page' => 'home-warranties'])

@section('content')
    @php

        $start_date = '';
        $end_date = '';
        $phone = '';

        if (isset($_GET['search'])) {
            if (!empty($_GET['start_date'])) {
                $start_date = $_GET['start_date'];
            }
            if (!empty($_GET['end_date'])) {
                $end_date = $_GET['end_date'];
            }
        }
        if (isset($_GET['search'])) {
            if (!empty($_GET['phone'])) {
                $phone = $_GET['phone'];
            }
        }
    @endphp
    @include('admin.layouts.headers.cards', ['title' => 'Home Warranty'])
    <div class="container-fluid mt--6">

        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <h3 class="mb-0">Manage Home Warranty Campaigns</h3>
                            </div>
                            <!-- @if(auth()->user()->hasRole('Super Admin'))
                             <div class="col-3">
                                <a href="{{ route('home-warranties.create') }}" class="btn btn-info float-right m-1">Sale
                                    Submission</a>
                                @if (isset($_GET['search']))
                                    <a href="{{ route('home-warranties.sales-report') }}?start_date={{ $start_date }}&end_date={{ $end_date }}&phone={{ $phone }}"
                                        class="btn btn-info float-right m-1">Export</a>
                                @else
                                    <a href="{{ route('home-warranties.sales-report') }}"
                                        class="btn btn-info float-right m-1">Export</a>
                                @endif

                            </div> 
                            @endif -->
                        </div>
                    </div>
                    <div>
                        <form action="{{ route('home-warranties.index') }}" method="GET" class="search p-3">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="search" value="1">
                                <div class="col-md-3">
                                    <span class="details">Start Date</span>
                                    <input type="date" name="start_date" value="{{ $start_date }}" class="form-control"
                                        placeholder="Start Date">
                                </div>
                                <div class="form-group col-md-3">
                                    <span class="details">End Date</span>
                                    <input type="date" name="end_date" value="{{ $end_date }}" class="form-control"
                                        placeholder="End Date">
                                </div>
                                <div class="form-group col-md-3">
                                    <span class="details">Phone</span>
                                    <input type="text" name="phone" value="{{ $phone }}" class="form-control"
                                        placeholder="Phone">
                                </div>
                                <div class="col-md-1" style="margin-top: -8px;">
                                    <label for="">&nbsp;</label>
                                    <input style="color: white" type="submit" class="btn btn-info btn-block"
                                        value="Search">
                                </div>
                                @if (in_array(Auth::user()->roles[0]->name, ['Super Admin','HomeWarranty Director','HomeWarranty Manager']))
                                <div class="form-group col-md-1" style="margin-top: 20px;">

                                    <a href="{{ route('home-warranties.create') }}" class="btn btn-info float-right m-1">Submission</a>
                                </div>
                                @endif
                                <!-- <div class="form-group col-md-1" style="margin-top: 20px;">
                                    @if (isset($_GET['search']))
                                        <a href="{{ route('home-warranties.sales-report') }}?start_date={{ $start_date }}&end_date={{ $end_date }}&phone={{ $phone }}"
                                            class="btn btn-info float-right form-control m-1">Export</a>
                                    @else
                                        <a href="{{ route('home-warranties.sales-report') }}"
                                            class="btn btn-info float-right form-control m-1">Export</a>
                                    @endif
                                </div> -->
                                <div>
                        </form>
                    </div>
                    <div class="table-responsive pb-3">
                        @include('admin.home-warranties.sales-report')
                        <div class="col-md-12 p-2">
                            {{ $home_warranties->links() }}
                        </div>
                    </div>

                </div>

            </div>

        </div>
        @include('admin.layouts.footers.auth')
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
@endsection


@push('js')
    <script>
		function remarks(val,id){
				$('#remarks').modal('show');
				document.getElementById('id_status').value=id;				
				document.getElementById('qa_status').value=val;

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
						'table':"home_warranties",
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
