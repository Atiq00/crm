@extends('admin.layouts.app', ['current_page' => 'solar'])

@section('content')
@push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('solars.index') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="arrow-left" stroke-width="3" width="12"></i> Go Back</a>
        </div>
    @endpush
    @include('admin.layouts.headers.cards', ['title' => 'Solar-Sale View'])

    <div class="container-fluid mt--6">

        <div class="card shadow">
            <div class="card-header border-0">
                <div class="table-responsive pb-3">
                    <table class="table align-items-center table-flush">
                        <tbody>
                            <tr>
                                <th>Project</th>
                                <td>{{ @$data->project->name ?? '-------' }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $data->first_name ?? '' }} {{ $data->last_name ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>Agent Name</th>
                                <td>{{ $data->user->name ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>Phone</th>
                                @if(Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('SolarClient'))
                                    <td>{{$data->phone }}</td>
                                @else
                                    <td>{{substr($data->phone, 0, 3) }}***{{ substr($data->phone,-4) }}</td>
                                @endif

                            </tr>
                            <tr>
                                <th>Client</th>
                                <td><b>{{ $data->client ? $data->client->name : '' ?? '' }}</b></td>

                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $data->email ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $data->address ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Zip Code</th>
                                <td>{{ $data->zipcode ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{ $data->city ?? '' }}</td>
                            </tr>


                            <tr>
                                <th>State</th>
                                <td>{{ $data->state ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>Lead ID</th>
                                <td>{{$data->lead_id ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>Home Owner</th>
                                <td>{{$data->homeowner ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>Eletric Bill</th>
                                <td>{{$data->electric_bill ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>Electric Provider</th>
                                <td>{{$data->electric_provider ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>Roof Shade</th>
                                <td>{{$data->roof_shade ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>Credit Score</th>
                                <td>{{ $data->credit_score ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>Credit Rating</th>
                                <td>{{ $data->credit_rating ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>Age</th>
                                <td>{{ $data->age ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Notes</th>
                                <td>{{ $data->notes ?? '' }}</td>
                            </tr>

                                                    
                                                    
                            <tr>
                                <th>Cash-Out</th>
                                <td>{{ @$data->cash_out ?? '-------' }}</td>
                            </tr>
                            <tr>
                                <th>Loan Balance</th>
                                <td>{{ @$data->loan_amount ?? '-------' }}</td>
                            </tr>
                            <tr>
                                <th>House Value</th>
                                <td>{{ @$data->house_value ?? '-------' }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ @$data->created_at ?? '-------' }}</td>
                            </tr>
                            @if(Auth::user()->hasRole('Solar Manager') || Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('EDDY AND SOLAR MANAGER') )
                            <tr>
                                <th>QA-Score</th>
                                <td> 
                                    {{@$result->percentage}}
                                </td>
                            </tr> 
                            <tr>
                                <th>QA Notes</th>
                                <td>{{ @$result->notes ?? '-------' }}</td>
                            </tr>
                            <tr>
                                <th>Recording Link</th>
                                <td>

                                    <audio controls>
                                        <source src="{{@$result->recording_link}}" type="audio/ogg">
                                        <source src="{{@$result->recording_link}}" type="audio/mpeg"> 
                                        </audio>
                                </td>
                            </tr>
                            
                            <tr>
                                <th>Appeal Status</th>
                                <td>{{ @$result->appeal->status ?? '-------' }}</td>
                            </tr> 
                            <tr>
                                <th>Appeal Remarks {{@$data->qa_status }}</th>
                                <td>{{ @$result->appeal->remarks ?? '-------' }}</td>
                            </tr>
                            @if(@$data->qa_status == "not-billable" && !(@$result->appeal->status))
                            <tr id="appealForm">
                                <th>Make Appeal</th>
                                <td >
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="appeal_remarks">
                                        </div>
                                        <div class="col-md-6">
                                            <button id="appealButton" onclick="makeAppeal()" class="btn btn-primary">Submit Appeal</button>
                                            <div id="loader" style="display: none" class="spinner-border text-primary"></div>
                                        </div>

                                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
                                        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
                                        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
                                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
                                        
                                    </div>
                                    
                                </td>
                            </tr>
                            @endif
                            @endif



                        </tbody>
                    </table>
                </div>

                {{-- <form action="#">
                                    <div class="row">
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>First Name</label>
                                            <input disabled type="text"  value="{{$data->first_name}}" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>Last Name</label>
                                            <input disabled type="text"  value="{{$data->last_name}}" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>Agent Name</label>
                                            <input disabled type="text"  value="{{$data->user->name}}" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>Phone</label>
                                            <input disabled type="text"  value="{{$data->phone}}" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>Client</label>
                                            <input disabled type="text"  value="{{@$data->client->name}}" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>Email</label>
                                            <input disabled type="text"  value="{{$data->email}}" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>Address</label>
                                            <input disabled type="text"  value="{{$data->address}}" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>Zip</label>
                                            <input disabled type="text"  value="{{$data->zipcode}}" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>City</label>
                                            <input disabled type="text"  value="{{$data->city}}" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>State</label>
                                            <input disabled type="text"  value="{{$data->state}}" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>Lead ID</label>
                                            <input disabled type="text"  value="{{$data->lead_id}}" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>Home Owner</label>
                                            <input disabled type="text"  value="{{$data->homeowner}}" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>Electric Bill</label>
                                            <input disabled type="text"  value="{{$data->electric_bill}}" class="form-control">
                                        </div>

                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>Electric Provider</label>
                                            <input disabled type="text"  value="{{$data->electric_provider}}" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>Roof Shade</label>
                                            <input disabled type="text"  value="{{$data->roof_shade}}" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>Credit Score</label>
                                            <input disabled type="text"  value="{{$data->credit_score}}" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>Credit Rating</label>
                                            <input disabled type="text"  value="{{$data->credit_rating}}" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-lg-3 form-group">
                                            <label>Age</label>
                                            <input disabled type="text"  value="{{$data->age}}" class="form-control">
                                        </div>



                                    </div>
                                </form> --}}
            </div>


        </div>
        @include('admin.layouts.footers.auth')
    </div>
@endsection


@push('js')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        function makeAppeal(){
            $('#loader').show();
            $('#appealButton').hide();
            var request = $.ajax({
                url: "{{ url('https://qmsv.touchstone-communications.com/api/voice-audit-appeal') }}",
                type: "POST",
                data: {
                    record_id: "{{@$data->record_id}}",
                    associate_id: "{{@$data->user->id}}",
                    user_id: "{{auth()->user()->id}}",
                    campaign_id: "3",
                    remarks:  document.getElementById("appeal_remarks").value,
                },
                dataType: "JSON",
                success: function(res) {
                    location.reload();
                    if (res.status == 200) {
                        location.reload();
                    }  else {
                         
                    }

                }
            });
        }
        
        
    </script>
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
