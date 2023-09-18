@extends('admin.layouts.app', ['current_page' => 'eddy-sales-import-form'])
@section('content')
    @include('admin.layouts.headers.cards', ['title' => 'Eddy-Sales-Import-Form'])
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        @if ($errors->any())
                            <div class="alert alert-danger"style="color: white;">
                                <strong class="text-secondary">Oops!</strong> There were some problems with your
                                input.<br><br>
                                <ul style="color: white;padding-left:20px">
                                    @foreach ($errors->all() as $error)
                                        <li style="color: white">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if ($message = Session::get('success'))
                            <div class="col-lg-12 text-center"
                                style="margin-top:10px;margin-bottom: 10px; padding-left:50px">
                                <div class="alert alert-success" style="color: white">
                                    {{ $message }}
                                </div>
                            </div>
                        @endif

                        
                        <form action="{{ route('eddy-sales.import') }}" method="POST" id="webform"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Upload File
                                        <a href="{{ asset('Eddy-Import-Format-Files.zip') }}" download>
                                            (Click here to download relevant files format)</a></label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile02"
                                            name="file">
                                        <label class="custom-file-label text-left" for="inputGroupFile02">
                                            <i data-feather="upload" width="15"></i>
                                            {{ __('labels.select_file') }}</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">&nbsp;</label>
                                    <button type="submit" class="form-control btn btn-info">Upload</button>
                                </div>
                            </div>
                            
                        </form> 

                        {{-- <form action="{{ route('eddy-sales.delete') }}" method="POST" id="webform"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">Select Date </label> 
                                    <input type="date" name="date" class="form-control">                                  
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">Select Type</label>
                                    <select value="{{ @$_GET['type'] }}" name="type" class="form-control">
                                        <option value="">--Select--</option>
                                        <option {{ @$_GET['type'] == 'Inbound' ? 'selected' : '' }} value="Inbound">Inbound</option>
                                        <option {{ @$_GET['type'] == 'Outbound' ? 'selected' : '' }} value="Outbound"> Outbound </option>
                                        <option {{ @$_GET['type'] == 'EddyEdu' ? 'selected' : '' }} value="EddyEdu">EddyEdu
                                        </option>
										 
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">&nbsp;</label>
                                    <button type="submit" class="form-control btn btn-info">Remove</button>
                                </div>
                            </div>
                            
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-10">
                                <h3 class="mb-0">Search</h3>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('eddy-sales.import-form') }}" method="GET" id="webform" style="padding:15px"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label class="form-control-label">AGENT ID</label>
                                <input type="text" value="{{ @$_GET['agent_id'] }}" name="agent_id" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-control-label">From Date</label>
                                <input type="date" value="{{ @$_GET['f_date'] }}" name="f_date" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-control-label">To Date</label>
                                <input type="date" value="{{ @$_GET['t_date'] }}" name="t_date" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-control-label">Select Type</label>
                                <select value="{{ @$_GET['type'] }}" name="type" class="form-control">
                                    <option value="">--Select--</option>
                                    <option {{ @$_GET['type'] == 'Inbound' ? 'selected' : '' }} value="Inbound">
                                        Inbound
                                    </option>
                                    <option {{ @$_GET['type'] == 'Outbound' ? 'selected' : '' }} value="Outbound">
                                        Outbound
                                    </option>
                                    <option {{ @$_GET['type'] == 'EddyEdu' ? 'selected' : '' }} value="EddyEdu">
                                        EddyEdu
                                    </option>
                                    <option {{ @$_GET['type'] == 'EducationFirst' ? 'selected' : '' }} value="EducationFirst">
                                        EducationFirst
                                    </option>
                                </select>
                            </div>
                        </div>
						<div class="row">
						<div class="form-group col-sm-2">
                            <button type="submit" class="form-control btn btn-info">Search</button>
                        </div>
						<div class="form-group col-sm-2">
                            <a href="{{ route('eddy-sales.import-form') }}" class="form-control btn btn-info">Clear</a>
                        </div>
						</div>
                        
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-11">
                                <h3 class="mb-0">Eddy Salesheet</h3>
                            </div>
                            <div class="col-1">
                                <a href="{{ route('eddy-sales.eddy-export') }}?agent_id={{ @$_GET['agent_id'] }}&date={{ @$_GET['date'] }}&type={{ @$_GET['type'] }}"
                                    class="btn btn-info btn-md">Export</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive pb-3">
                        <table class="table align-items-center table-flush" id="basic-datatable">
                            <thead class="thead-light">
                                <tr style="background: lightblue;">
                                    <td>Grand-Total-Hours</td> 
                                    <td id="Hours">{{@$hours}}</td>
                                    <td>Total Count</td> 
                                    <td id="Hours">{{@$eddy->total()}}</td>
                                </tr>
                                <tr>
                                    @if(request()->type=="Inbound" || request()->type=="Outbound" || request()->type=="EducationFirst")
                                        <th scope="col" width="3%">ID</th>
                                        <th scope="col" width="3%">Sale Date</th> 
                                        <th scope="col" width="3%">Agent ID</th>
                                        <th scope="col" width="3%">Billable Hours</th>
                                        <th scope="col" width="3%">Call Hours</th>
                                        @if(request()->type=="Inbound" || request()->type=="EducationFirst")
                                            <th scope="col" width="3%">Calls Per Billable Hours</th>
                                        @endif
                                        <th scope="col" width="3%">Total Calls
                                        </th>
                                        <th scope="col" width="3%">Total Connects
                                        </th>
                                        <th scope="col" width="3%">Connects
                                        </th>
                                        <th scope="col" width="3%">Connect Percentage
                                        </th>
                                        <th scope="col" width="3%">Deassign Percentage
                                        </th>
                                        <th scope="col" width="3%">AHT
                                        </th>
                                        <th scope="col" width="3%">Edu Transfers
                                        </th>
                                        <th scope="col" width="3%">Edu TPH
                                        </th>
                                        <th scope="col" width="3%">Edu Transfer Rate
                                        </th>
                                        <th scope="col" width="3%">Edu Conversions
                                        </th>
                                        @if(request()->type=="Inbound" || request()->type=="EducationFirst")
                                            <th scope="col" width="3%">Edu CPH</th>
                                        @endif
                                        <th scope="col" width="3%">Edu Conv Percentage of Transfers
                                        </th>
                                        <th scope="col" width="3%">Edu Conv Percentage of Connects
                                        </th>
                                        <th scope="col" width="3%">Edu Conv Percentage of total calls
                                        </th>
                                        {{-- <th scope="col" width="3%">Transfers
                                        </th>
                                        <th scope="col" width="3%">Transfers Percentage
                                        </th> --}}
                                    @endif
                                    @if(request()->type=="EddyEdu")
                                        <th scope="col" width="3%">ID</th>
                                        <th scope="col" width="3%">Sale Date</th> 
                                        <th scope="col" width="3%">Agent ID</th>
                                        <th scope="col" width="3%">Billable Hours</th> 
                                        <th scope="col" width="3%">Call Hours</th>
                                        <th scope="col" width="3%"> Connects </th>
                                        <th scope="col" width="3%">People
                                        </th>
                                        <th scope="col" width="3%">Forms
                                        </th>
                                        <th scope="col" width="3%">LTs
                                        </th>
                                        <th scope="col" width="3%">Conv %
                                        </th>
                                        <th scope="col" width="3%">LT %
                                        </th>
                                        <th scope="col" width="3%">LPP
                                        </th>
                                        {{-- <th scope="col" width="3%">LPH
                                        </th> --}}
                                        <th scope="col" width="3%">WLPH
                                        </th>
                                        {{-- <th scope="col" width="3%">PPH
                                        </th> --}}
                                        {{-- <th scope="col" width="3%">WLPC
                                        </th> --}}
                                        <th scope="col" width="3%">Type</th>
                                    @endif
                                    {{-- <th scope="col" width="3%">Created at</th> --}}

                                </tr>
                            </thead>
                            <?php $count = 1; $hours=0;?>
                            @if ($eddy)
                            <tbody>
                                
                                
                                @if(request()->type || request()->date || request()->agent_id)
                                
                                @foreach ($eddy as $key=> $row)
                                    <tr>
                                        @if(request()->type=="Inbound" || request()->type=="Outbound" || request()->type=="EducationFirst")
                                            <td>{{ $eddy->firstItem()+$key }}</td>
                                            <td>{{ date('m-d-Y', strtotime(@$row->sale_date)) }}</td> 
                                            <td @if(!@$row->user->HRMSID) style="background:#f56342;color:white" @endif >{{ @$row->agent_id ?? 0 }}  <b>{{@$row->user->HRMSID}}</b> </td>
                                            <td><?php $hours=$hours+ @$row->billable_hours;echo @$row->billable_hours;?></td>
                                            <td>{{ @$row->call_hours ?? '' }}</td>
                                            @if(request()->type=="Inbound" || request()->type=="EducationFirst")
                                                <td>{{ @$row->calls_per_billable_hours ?? '' }}</td>
                                            @endif
                                            <td>{{ @$row->total_calls ?? '' }}</td>
                                            <td>{{ @$row->total_connects ?? '' }}</td>
                                            <td>{{ @$row->connects ?? '' }}</td>
                                            <td>{{ @$row->connect_percentage ?? '' }}</td>
                                            <td>{{ @$row->deassign_percentage ?? '' }}</td>
                                            <td>{{ @$row->aht ?? '' }}</td>
                                            <td>{{ @$row->edu_transfers ?? '' }}</td>
                                            <td>{{ @$row->edu_tph ?? '' }}</td>
                                            <td>{{ @$row->edu_transfer_rate ?? '' }}</td>
                                            <td>{{ @$row->edu_conversions ?? '' }}</td>
                                            @if(request()->type=="Inbound" || request()->type=="EducationFirst")
                                                <td>{{ @$row->edu_cph ?? '' }}</td>
                                            @endif
                                            <td>{{ @$row->edu_conv_percentage_of_transfers ?? '' }}</td>
                                            <td>{{ @$row->edu_conv_percentage_of_connects ?? '' }}</td>
                                            <td>{{ @$row->edu_conv_percentage_of_total_calls ?? '' }}</td>
                                            {{-- <td>{{ @$row->transfers ?? '' }}</td>
                                            <td>{{ @$row->transfers_percentage ?? '' }}</td> --}}
                                        @endif
                                        @if(request()->type=="EddyEdu")
                                            <td>{{ $eddy->firstItem()+$key }}</td>
                                            <td>{{ date('m-d-Y', strtotime(@$row->sale_date)) }}</td> 
                                            <td @if(!@$row->user->HRMSID) style="background:#f56342;color:white" @endif>{{ @$row->agent_id ?? 0 }}  <b>{{@$row->user->HRMSID}}</b></td>
                                            <td><?php $hours=$hours+ @$row->billable_hours;echo @$row->billable_hours;?></td>
                                            <td>{{ @$row->call_hours ?? '' }}</td>
                                            <td>{{ @$row->connects ?? '' }}</td>
                                            <td>{{ @$row->people ?? '' }}</td>
                                            <td>{{ @$row->forms ?? '' }}</td>
                                            <td>{{ @$row->lts ?? '' }}</td>
                                            <td>{{ @$row->conv_percentage ?? '' }}</td>
                                            <td>{{ @$row->lt_percentage ?? '' }}</td>
                                            <td>{{ @$row->lpp ?? '' }}</td>
                                            {{-- <td>{{ @$row->lph ?? '' }}</td> --}}
                                            <td>{{ @$row->wlph ?? '' }}</td>
                                            {{-- <td>{{ @$row->pph ?? '' }}</td>
                                            <td>{{ @$row->wlpc ?? '' }}</td> --}}
                                            <td>{{ @$row->type }}</td>
                                        @endif
                                        {{-- <td>{{ date('m-d-Y', strtotime(@$row->created_at)) }}</td> --}}
                                    </tr>
                                @endforeach
                               
                                @endif
                            </tbody>
                            @endif
                            
                        </table>  
                        @if(request()->type=="Inbound" || request()->type=="Outbound" || request()->type=="EddyEdu" || request()->type=="EducationFirst" )
                            {{ @$eddy->appends(['type'=>@$_GET['type'],'agent_id'=>@$_GET['agent_id'],'f_date'=>@$_GET['f_date'],'t_date'=>@$_GET['t_date'] ])->links() }} 
                        @endif
                    </div>
                </div>
            </div>


        </div>
        @include('admin.layouts.footers.auth')
    </div>
@endsection
@push('js')
    <script>
        // document.getElementById('Hours').innerHTML="{{($hours) ? $hours.' hrs' : '0hrs'}}"
        $('#inputGroupFile02').on('change', function() {
            //get the file name
            var fileName = $(this).val();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        })
        $(document).ready(function() {
            $('#basic-datatable').DataTable({
            paging: false,  
            info: false, 
        });
        });
    </script>
@endpush
