@extends('admin.layouts.app', ['current_page' => 'solar-submission'])

@section('content')

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
            <a href="{{ route('solars.index') }}" class="btn btn-sm btn-icon btn-neutral">
                <i data-feather="arrow-left" stroke-width="3" width="12"></i> Go Back</a>
        </div>
    @endpush
    @include('admin.layouts.headers.cards', ['title' => 'Solar'])
    <div class="container-fluid mt--6">

        <div class="row">

            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <img style="display: block;margin-left: auto; margin-right: auto;width: 50%; display:none"
                                    src="{{ url('loader.gif') }}" id="loader">
                            </div>
                        </div>

                        <div class="row" id="searchForm">
                            <div class="col-3">
                                <h3 class="mb-0">Solar Campaigns Submission</h3>
                            </div>
                            <div class="col-2">
                                <h3 class="mb-0 text text-danger" id="recordNotFoundLabel" style="display: none">Record Not
                                    Found</h3>
                            </div>
                            <div class="col-2">
                                <h3 class="mb-0 text text-danger" id="alreadyASaleLabel" style="display: none">Already a Sale</h3>
                                <h3 class="mb-0 text text-danger" id="JornayaIDSolarTLabel" style="display: none">JorNaya ID is Invalid</h3>
                            </div>
                            <div class="col-3 ">
                                <input style="color: black" style="border: 2px solid;" type="number" id="search"
                                    name="search" disabled minlength="10" class="form-control" placeholder="Record ID or Phone #">
                            </div>
                            <div class="col-2 ">
                                <a href="#" onclick="searchRecord()" class="btn btn-primary float-right">Search Sale
                                    Record</a>
                            </div>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger" style="color: red;">
                                <strong class="text-secondary">Oops!</strong> There were some problems with your
                                input.<br><br>
                                <ul style="color: red;padding-left:20px">
                                    @foreach ($errors->all() as $error)
                                        <li style="color: red">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if ($message = Session::get('success'))
                            <div class="col-lg-12 text-center"
                                style="margin-top:10px;margin-bottom: 10px; padding-left:50px">
                                <div class="alert alert-success" style="color: lightgreen">
                                    {{ $message }}
                                </div>
                            </div>
                        @endif
                        @if ($message = Session::get('error'))
                            <div class="col-lg-12 text-center"
                                style="margin-top:10px;margin-bottom: 10px; padding-left:50px">
                                <div class="alert alert-danger" style="color: white">
                                    {{ $message }}
                                </div>
                            </div>
                        @endif
                        <form action="{{ route('solars.store') }}" method="POST" id="webform">
                            @csrf


                            <input style="color: black" type="hidden" name="lead_id" id="leadid_token" class="form-control"
                                placeholder="leadid_token">

                            <input style="color: black" type="hidden" name="optin_cert" id="optin_cert"  class="form-control"> 

                            <input style="color: black" type="hidden" name="record_id" id="record_id">
                            <input style="color: black" type="hidden" name="JornayaIDSolarT" id="JornayaIDSolarT">
                            <div class="row">
                                <div class="form-group col-md-6" style="display: block;" id="clients">
                                    <b class="details">Select Client</b>
                                    <select name="clients" id="ddclients" required onchange="selectClient(this.value)"
                                        class="form-control selection_style" style=" background: lightblue; color: black;">
                                        <option value="">Select </option>
                                        @foreach ($projects as $row)
                                            @php
                                                if($row->project_code == "PRO0155"){
                                                    continue;
                                                }
                                            @endphp
                                            
                                            <option value="{{ $row->project_code }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="first_name">
                                    <span class="details">First name</span>
                                    <input style="color: black" required type="text" name="first_name"
                                        data-id="first_name" class="form-control" placeholder="First name">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="last_name">
                                    <span class="details">Last name</span>
                                    <input style="color: black" required type="text" name="last_name"
                                        data-id="last_name" class="form-control" placeholder="Last name">
                                </div>
                                <div class="form-group col-md-6" style="display: none" id="agent_name">
                                    <span class="details">Agent Name</span>
                                    <input style="color: black" type="text" name="agent_name" class="form-control"
                                        placeholder="Agent Name">
                                </div>

                                <div class="form-group col-md-6" style="display: block" id="phone">
                                    <span class="details">Phone</span>
                                    <input style="color: black" required readonly type="text" name="phone"
                                        data-id="phone" class="form-control" placeholder="Phone">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="address">
                                    <span class="details">Address</span>
                                    <input style="color: black" type="text" name="address" data-id="address"
                                        class="form-control" placeholder="Address">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="city">
                                    <span class="details">City</span>
                                    <input style="color: black" type="text" name="city" data-id="city"
                                        class="form-control" placeholder="City">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="state">
                                    <span class="details">state</span>
                                    <select required onchange="slectState(this)" name="state" id="st" class="form-control">
                                        <option value="">Select State</option>
                                        @foreach ($states as $row)
                                            <option>{{ $row->state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- <div class="form-group col-md-6" style="display: block" id="state">
                                    <span class="details">state</span>
                                    <select required name="state" class="form-control">
                                        <option value="">Select State</option>
                                        <option> CT </option>
                                        <option> FL </option>
                                        <option> MA </option>
                                        <option> MI </option>
                                        <option> NJ </option>
                                        <option> NV </option>
                                        <option> NY </option>
                                        <option> TX </option>
                                    </select>
                                </div> -->
                                <!-- <div class="form-group col-md-6" style="display: block" id="state_solar_trinity">
                                    <span class="details">state</span>
                                    <select name="state"  class="form-control">
                                    <option value="">Select </option>
                                        <option> NJ </option>
                                        <option> MA </option>
                                        <option> NY </option>
                                        <option> CT </option>
                                        <option> MD </option>
                                        <option> PA </option>
                                        <option> RI </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="electric_solar_trinity">
                                    <span class="details">Electric Provider</span>
                                    <select name="electric_provider"  class="form-control">
                                    <option value="">Select </option>
                                        <option> PSE&G  </option>
                                        <option> JCP&L </option>
                                        <option> ACE  </option>
                                        <option> Orange and Rockland </option>
                                        <option> Ace and Vineland- As long as it is not in a BLACKED OUT AREA </option>
                                        <option> National Grid  </option>
                                        <option> Eversource  - NSTAR </option>
                                        <option> Unitil </option>
                                        <option> WMECO </option>
                                        <option> PSE&G LI (formerly LIPA) </option>
                                        <option> Orange and Rockland </option>
                                        <option> ConEdison </option>
                                        <option> Central Hudson </option>
                                        <option> NYSEG </option>
                                        <option> Eversource </option>
                                        <option> United Illuminating </option>
                                        <option> BG&E (Baltimore Gas & Electric) </option>
                                        <option> SMECO (Southern Maryland Electric Company) </option>
                                        <option> Constellation (formerly PEPCO) </option>
                                        <option> Choptank Electric Coop </option>
                                        <option> Delmarva Power </option>
                                        <option> Met-Ed  </option>
                                        <option> PPL  </option>
                                        <option> PECO  </option>
                                        <option> Penelec  </option>
                                        <option> Duquesne Light  </option>
                                        <option> National Grid  </option>
                                    </select>
                                </div> -->
                                 <div class="form-group col-md-6" style="display: none" id="electric_provider">
                                    <span class="details">Electric Provider</span>
                                    <input style="color: black" type ="Text" name="electric_provider" class="form-control"
                                        placeholder="Electric Provider">
                                </div> 


                                <div class="form-group col-md-6" style="display: block" id="zip_code">
                                    <span class="details">Zip Code</span>
                                    <input style="color: black" type="text" name="zip_code" data-id="zip_code"
                                        class="form-control" placeholder="Zip Code">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="email">
                                    <span class="details">Email</span>
                                    <input style="color: black" type="text" name="email" data-id="email"
                                        class="form-control" placeholder="Email">
                                </div>
                                <div class="form-group col-md-6" style="display: none" id="smoker">
                                    <span class="details">Smoker</span>
                                    <select name="smoker" class="form-control">
                                        <option>Yes</option>
                                        <option>No</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6" style="display: none" id="beneficiary">
                                    <span class="details">Beneficiary</span>
                                    <select name="beneficiary" class="form-control">
                                        <option>Spouse</option>
                                        <option>Daughter </option>
                                        <option>Son</option>
                                        <option>Sibling </option>
                                        <option>Others</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6" style="display: none" id="age">
                                    <span class="details">Age</span>
                                    <input style="color: black" type="number" name="age" class="form-control"
                                        placeholder="Age">
                                </div>
                                <div class="form-group col-md-6" style="display: none" id="coverage">
                                    <span class="details">Coverage</span>
                                    <input style="color: black" type="text" name="coverage" class="form-control"
                                        placeholder="Coverage">
                                </div>
                                <div class="form-group col-md-6" style="display: none" id="house_type">
                                    <span class="details">HouseType</span>
                                    <input style="color: black" type="text" name="housetype" class="form-control"
                                        placeholder="HouseType">
                                </div>
                                <div class="form-group col-md-6" style="display: none" id="state_sm">
                                    <span class="details">State</span>
                                    <input style="color: black" type="text" name="state_sm" class="form-control"
                                        placeholder="state">
                                </div>
                                <div class="form-group col-md-6" style="display: none" id="disclaimer">
                                    <span class="details">Disclaimer</span>
                                    <select name="disclaimer" class="form-control">
                                        <option>Yes</option>
                                        <option>No</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6" style="display: none" id="major_health_issues">
                                    <span class="details">Major Health Issues:</span>
                                    <select name="major_health_issues" class="form-control">
                                        <option>Yes</option>
                                        <option>No</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6" style="display: none" id="app_date_time">
                                    <span class="details">Appointment Date</span>
                                    <input style="color: black" type="datetime-local"="" name="app_date_time"
                                        class="form-control" placeholder="Appointment Date-T-me">
                                </div>
                                <!-- <div class="form-group col-md-6" style="display: none" id="solar_rep">
                                    <span class="details">Solar Rep</span>
                                    <select name="solar_rep" id="" class="form-control">
                                        <option>--Select--</option>
                                        <option value="chris">Chris</option>
                                        <option value="julius">Julius</option>
                                        <option value="tim">Tim</option>

                                    </select>
                                </div> -->

                                <!-- <div class="form-group col-md-6" style="display: none" id="electric_bill_monthly" >
                                        <span class="details">Electric Bill Monthly</span>
                                        <input style="color: black"  type="text" name="electric_bill_monthly" id="electric_bills_monthly" class="form-control" placeholder="Electric Bill Monthly">
                                    </div> -->

                                <div class="form-group col-md-6" style="display: none" id="electric_bill_monthly">
                                    <span class="details">Electric Bill Monthly</span>
                                    <select name="electric_bill" class="form-control">
                                        {{-- <option value="$0-50">$0-50</option>
                                        <option value="$51-100">$51-100</option> --}}
                                        <option value="$101-150">$101-150</option>
                                        <option value="$151-200">$151-200</option>
                                        <option value="$201-300"> $201-300</option>
                                        <option value="$301-400"> $301-400</option>
                                        <option value="$401-500"> $401-500</option>
                                        <option value="$501-600"> $501-600</option>
                                        <option value="$601-700"> $601-700</option>
                                        <option value="$701-800"> $701-800</option>
                                        <option value="$801+"> $801+</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6" style="display: none" id="roof_shade">
                                    <span class="details">Roof Shade</span>
                                    <select name="roof_shade" class="form-control">
                                        <option value="No Shade">No Shade</option>
                                        <option value="A Little Shade">A Little Shade</option>
                                        <option value="A Lot Of Shade">A Lot Of Shade</option>
                                        <option value="Uncertain">Uncertain</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6" style="display: none" id="homeowner">
                                    <span class="details">Home Owner</span>
                                    <select name="homeowner" class="form-control">
                                        <option value="YES">YES</option>
                                        <option value="NO">NO</option>
                                        <option value="COMMERCIAL">COMMERCIAL</option>
                                        <option value="CONDO">CONDO</option>
                                        <option value="MOBILE HOME">MOBILE HOME</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6" style="display: none" id="credit_score">
                                    <span class="details">Credit Score</span>
                                    <input style="color: black" type="text" name="credit_score" id="CreditScore"
                                        class="form-control" placeholder="Credit Score">
                                </div>
                                <div class="form-group col-md-6" style="display: none" id="credit_rating">
                                    <span class="details">Credit rating</span>
                                    <select name="credit_rating" id="" class="form-control">
                                        <option value="750">Excellent</option>
                                        <option value="650">Good</option>
                                        <option value="620">Fair</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6" style="display: none" id="notes">
                                    <span class="details">Notes</span>
                                    <textarea name="notes" class="form-control" cols="30" rows="4"></textarea>
                                </div>
                                <div class="form-group col-md-6" style="display: none" id="monthly_payment">
                                    <span class="details">Monthly-Payment</span>
                                    <input style="color: black" type="text" name="monthly_payment"
                                        class="form-control" placeholder="Monthly-payment">

                                </div>
                                <div class="form-group col-md-6" style="display: none" id="company">
                                    <span class="details">Company</span>
                                    <input style="color: black" type="text" name="company"
                                        class="form-control" placeholder="Company">

                                </div>
                                <div class="form-group col-md-6" style="display: none" id="income">
                                    <span class="details">Income</span>
                                    <input style="color: black" type="text" name="income" class="form-control"
                                        placeholder="Income">

                                </div>
                                <div class="form-group col-md-6" style="display: none" id="call_url">
                                    <span class="details">Call Recording url</span>
                                    <input type="url" name="call_url" class="form-control">
                                </div>
                                <div class="form-group col-md-6" style="display: none" id="street">
                                    <span class="details">Street</span>
                                    <input style="color: black" type="text" name="street"
                                        class="form-control" placeholder="Street">
                                </div>
                                <div class="form-group col-md-6" style="display: none" id="appt">
                                    <span class="details"></span>
                                    <a href="#" onclick="setWebLink()">Click Here for Appt</a>
                                </div>
                                

                                <div class="form-group col-md-6" id="submit"
                                    style="display: block; margin-top: -8px;">
                                    <label for="">&nbsp;</label>
                                    <input style="color: black" type="submit" class="btn btn-info btn-block"
                                        value="Submit">
                                </div>
                                <div>
                        </form>
                        
                    </div>
                    <div style="width: 700px; height: 500px;" id="map_canvas"></div>
                </div> 
            </div>
        </div>
        @include('admin.layouts.footers.auth')
    </div>
@endsection
@push('js')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTbYZF_kDxKNopcvej6oh-eVs1z9Xq2J0"></script>
    <script>
         
        var map = null;
        var myMarker;
        var myLatlng; 
        function initializeGMap(address) {
            geocoder = new google.maps.Geocoder(); 
            geocoder.geocode( { 'address': address}, function(results, status) {             
                var latitude = parseFloat(results[0].geometry.location.lat());
                var longitude = parseFloat(results[0].geometry.location.lng());
                console.log('latitude='+latitude+",longitude="+longitude)
                myLatlng = new google.maps.LatLng(parseFloat(latitude), parseFloat(longitude));
                var myOptions = {
                zoom: 20,
                zoomControl: true,
                center: {
                    lat: parseFloat(latitude),
                    lng: parseFloat(longitude)
                },
                mapTypeId: google.maps.MapTypeId.HYBRID
                };
                map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                myMarker = new google.maps.Marker({
                position: {
                    lat: parseFloat(latitude),
                    lng: parseFloat(longitude)
                } 
                }); 
                myMarker.setMap(map);  
            });
            
        } 
        
        // initializeGMap("F8, 4 Jinnah Avenue, F-8/4 F 8/4 F-8, Islamabad, Islamabad Capital Territory 44220, Pakistan");
    
    </script>
    <script>
        var projectCode='';
        function searchRecord() {
            $('#loader').show();
            $('#searchForm').hide();
            $('#webform').hide();
            var id = document.getElementById('search').value;
            document.getElementById('search').style.border = "2px solid lightgray";
            var request = $.ajax({
                url: "{{ url('/search_record') }}",
                type: "GET",
                data: {
                    record_id: id,
                    table: "sale_records"
                },
                dataType: "JSON",
                success: function(res) {
                    $('#loader').hide();
                    $('#searchForm').show();
                    if (res.status == 204) {
                        $('#webform').hide();
                        $('#alreadyASaleLabel').show();                         
                    }
                    if (res.status == 200) {
                        $('#webform').show();
                        $('#alreadyASaleLabel').hide();
                    }

                    if (res.status == 200) {
                        $('#webform').show();
                        document.getElementById('record_id').value = res.data.ID;
                        document.querySelector("input[name=first_name]").value = res.data.FirstName;
                        document.querySelector("input[name=last_name]").value = res.data.LastName;
                        document.querySelector("input[name=email]").value = res.data.Email;
                        document.querySelector("input[name=city]").value = res.data.City;
                        document.querySelector("input[name=phone]").value = res.data.Phone;
                        document.querySelector("input[name=zip_code]").value = res.data.ZipCode;
                        document.querySelector("input[name=address]").value = res.data.PriAddress;
                        // document.getElementById("electric_bills_monthly").value = res.data.ElectricBill;
                        // document.getElementById("electric_providers").value = res.data.ElectricProvider;
                        document.getElementById("CreditScore").value = res.data.CreditScore;
                        document.getElementById('st').value = res.data.State;
                        if ((res.data.Client_id == 63 || res.data.Client_id == "63") && projectCode !="PRO0098") { 
                            $('#alreadyASaleLabel').show();  
                        }
                        if (res.data.Client_id == 63 || res.data.Client_id == "63") { 
                            if(res.data.JornayaID){
                                document.getElementById('JornayaIDSolarT').value = res.data.JornayaID;
                            }                             
                            else{ 
                                document.getElementById('JornayaIDSolarT').value='';
                                $('#webform').show();
                                $('#JornayaIDSolarTLabel').show();
                            }
                        } 
                        let ddclients = document.getElementById('ddclients').value;
                        if(ddclients == "PRO0033"){
                            document.getElementById('map_canvas').style.display="block";
                            initializeGMap(res.data.PriAddress);
                        }                            
                        else{
                            document.getElementById('map_canvas').style.display="block";
                        }

                    } else {
                        
                        document.querySelector("input[name=first_name]").value = "";
                        document.querySelector("input[name=last_name]").value = "";
                        document.querySelector("input[name=email]").value = "";
                        document.querySelector("input[name=city]").value = "";
                        document.querySelector("input[name=state]").value = "";
                        document.querySelector("input[name=phone]").value = "";
                        document.querySelector("input[name=zip_code]").value = "";
                        document.querySelector("input[name=address]").value = "";
                    }

                }
            });

        }
        // function slectState(val){ 
        // 	var ddclient = document.getElementById("ddclients").value;
        // 	var ddstate = val.value;
        // 	var ddoptions = "";

        // 	if(ddclient=="PRO0098"){
        // 	if(ddclient=="PRO0098" && ddstate=="NJ"){
        // 		ddoptions +="<option>PSE&G</option>";
        // 		ddoptions +="<option>JCP&L</option>";
        // 		ddoptions +="<option>ACE</option>";
        // 		ddoptions +="<option>Orange and Rockland</option>";
        // 		ddoptions +="<option>Ace and Vineland- As long as it is not in a BLACKED OUT AREA </option>";			
        // 	}else if(ddclient=="PRO0098" && ddstate=="MA"){
        // 		ddoptions +="<option>National Grid</option>";
        // 		ddoptions +="<option>Eversource  - NSTAR</option>";
        // 		ddoptions +="<option>Unitil</option>";
        // 		ddoptions +="<option>WMECO</option>";
        // 		ddoptions +="<option>Ace and Vineland- As long as it is not in a BLACKED OUT AREA </option>";			
        //     }else if(ddclient=="PRO0098" && ddstate=="NY"){
        //       ddoptions +="<option>PSE&G LI (formerly LIPA)</option>";  
        //       ddoptions +="<option>Orange and Rockland  </option>";
        //       ddoptions +="<option>ConEdison  </option>";
        //       ddoptions +="<option>Central Hudson  </option>";
        //       ddoptions +="<option>NYSEG </option>";		
        // 	}else if(ddclient=="PRO0098" && ddstate=="CT"){
        //       ddoptions +="<option>Eversource</option>"; 
        //       ddoptions +="<option>United Illuminating </option>"; 		
        // 	}else if(ddclient=="PRO0098" && ddstate=="MD"){
        // 		ddoptions +="<option>BG&E (Baltimore Gas & Electric) </option>";
        // 		ddoptions +="<option>SMECO (Southern Maryland Electric Company) </option>";
        // 		ddoptions +="<option>Constellation (formerly PEPCO)</option>";
        // 		ddoptions +="<option>Choptank Electric Coop</option>";
        // 		ddoptions +="<option>Delmarva Power</option>";		
        // 	}else if(ddclient=="PRO0098" && ddstate=="PA"){
        // 		ddoptions +="<option>Met-Ed</option>"; 
        // 		ddoptions +="<option>PPL </option>";
        // 		ddoptions +="<option>PECO </option>";
        // 		ddoptions +="Penelec </option>";
        // 		ddoptions +="<option>Duquesne Light</option>";  
        // 	}else if(ddclient=="PRO0098" && ddstate=="RI"){
        // 		ddoptions +="<option>National Grid </option>"; 		
        // 	}
        // 	document.getElementById("electric_providers").innerHTML=ddoptions;
        // 	}else{


        //     $.ajax({
        //     url: "{{ url('/api/select_electric') }}",
        //     type: "GET",
        //     data: {val :val.value }, 
        //     success:function (res){  

        //         if(res){
        //             var options ='';
        //             for(let i=0; i<res.length;i++){ 
        //                 let vr = (res[i].id); 
        //                 options +="<option>"+(res[i].electric_provider)+"</option>"; 

        //             }
        //             document.getElementById("electric_providers").innerHTML=options;

        //         }
        //     }
        //     }); 
        // 	}
        // }
        function selectClient(val) {
            projectCode=val
            document.getElementById("search").disabled = false;
            document.getElementById('call_url').style.display = "none";
            // $('#webform')[0].reset();
            if (val == "PRO0033") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "none";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('roof_shade').style.display = "block";
                document.getElementById('homeowner').style.display = "block";
                document.getElementById('credit_score').style.display = "block";
                document.getElementById('credit_rating').style.display = "block";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            } else if (val == "CS0002" || val == "SS0003" || val == "SE0005" ||
                val == "PP0008" || val == "PE0009" || val == "SW0013" || val == "PT0015" || val == "EP0016" ||
                val == "SB0010" || val == "TA0012" || val == "PR0014") {

                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('appt').style.display = "none";



                document.getElementById('agent_name').style.display = "none";

                if (val == "PR0014")
                    document.getElementById('call_url').style.display = "block";

                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "none";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "none";
                document.getElementById('roof_shade').style.display = "none";
                document.getElementById('homeowner').style.display = "none";
                document.getElementById('credit_score').style.display = "none";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "none";
                document.getElementById('app_date_time').style.display = "none";
                document.getElementById('electric_bill_monthly').style.display = "none";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                document.getElementById('state_solar_trinity').style.display = "none";
                document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            } else if (val == "SN0004" || val == "PRO0095" || val == "PRO0124") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('appt').style.display = "none";
                if(val=="PRO0095"){
                    document.getElementById('roof_shade').style.display = "none";
                    document.getElementById('homeowner').style.display = "block";
                }
                document.getElementById('electric_provider').style.display = "none";
                document.getElementById('electric_bill_monthly').style.display = "block";
                
                document.getElementById('credit_score').style.display = "block";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "block";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            } else if (  val == "PRO0125") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "block";
                document.getElementById('email').style.display = "none";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "none";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('city').style.display = "none";
                document.getElementById('state_sm').style.display = "none";
                document.getElementById('notes').style.display = "none";
                // if(val=="PRO0074"){
                //     document.getElementById('agent_name').style.display = "none";
                //     document.getElementById('house_type').style.display = "block";
                //     document.getElementById('notes').style.display = "block";
                // }
                
                document.getElementById('electric_provider').style.display = "none";
                document.getElementById('electric_bill_monthly').style.display = "none";
                document.getElementById('roof_shade').style.display = "none";
                document.getElementById('homeowner').style.display = "none";
                document.getElementById('credit_score').style.display = "none";
                document.getElementById('credit_rating').style.display = "none";
                
                document.getElementById('app_date_time').style.display = "none";
                document.getElementById('solar_rep').style.display = "none";
                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";

            }
            else if (val == "PRO0074") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "none";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "none";
                document.getElementById('city').style.display = "none";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('electric_bill_monthly').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('roof_shade').style.display = "none";
                document.getElementById('homeowner').style.display = "none";
                document.getElementById('credit_score').style.display = "none";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('app_date_time').style.display = "none";
                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "block";
                document.getElementById('appt').style.display = "none";

            } 
            else if (val == "PRO0172") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "none";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "none";
                document.getElementById('city').style.display = "none";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('electric_bill_monthly').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('roof_shade').style.display = "none";
                document.getElementById('homeowner').style.display = "none";
                document.getElementById('credit_score').style.display = "none";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('app_date_time').style.display = "none";
                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "block";
                document.getElementById('appt').style.display = "none";

            } 
            else if (val == "PRO0093") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "block";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('roof_shade').style.display = "none";
                document.getElementById('homeowner').style.display = "block";
                document.getElementById('credit_score').style.display = "block";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "block";
                document.getElementById('solar_rep').style.display = "block";
                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            } else if (val == "PRO0082") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "block";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('roof_shade').style.display = "block";
                document.getElementById('homeowner').style.display = "block";
                document.getElementById('credit_score').style.display = "block";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            } 
            else if (val == "PRO0126") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "block";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('roof_shade').style.display = "none";
                document.getElementById('homeowner').style.display = "none";
                document.getElementById('city').style.display = "block";
                document.getElementById('credit_score').style.display = "block";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            }  
            else if (val == "PRO0128") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "block";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('roof_shade').style.display = "none";
                document.getElementById('homeowner').style.display = "none";
                document.getElementById('city').style.display = "block";
                document.getElementById('credit_score').style.display = "block";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            }  
            else if (val == "PRO0103") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "block";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('roof_shade').style.display = "block";
                document.getElementById('homeowner').style.display = "block";
                document.getElementById('credit_score').style.display = "block";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            } else if (val == "PRO0104") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "block";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('roof_shade').style.display = "block";
                document.getElementById('homeowner').style.display = "block";
                document.getElementById('credit_score').style.display = "block";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            } else if (val == "PRO0112") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('city').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "block";
                document.getElementById('income').style.display = "block";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('monthly_payment').style.display = "block";
                document.getElementById('roof_shade').style.display = "block";
                document.getElementById('homeowner').style.display = "block";
                document.getElementById('credit_score').style.display = "block";
                document.getElementById('credit_rating').style.display = "block";
                document.getElementById('notes').style.display = "block";
                document.getElementById('agent_name').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";
                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('appt').style.display = "none";

            } else if (val == "PRO0105") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "block";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('roof_shade').style.display = "block";
                document.getElementById('homeowner').style.display = "block";
                document.getElementById('credit_score').style.display = "block";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            }  
            else if (val == "PRO0106") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "block";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('roof_shade').style.display = "block";
                document.getElementById('homeowner').style.display = "block";
                document.getElementById('credit_score').style.display = "block";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            }
            else if (val == "PRO0154") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "none";
                document.getElementById('electric_bill_monthly').style.display = "none";
                document.getElementById('roof_shade').style.display = "none";
                document.getElementById('homeowner').style.display = "none";
                document.getElementById('credit_score').style.display = "none";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            }             
            else if (val == "PRO0109") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "block";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('roof_shade').style.display = "block";
                document.getElementById('homeowner').style.display = "block";
                document.getElementById('credit_score').style.display = "block";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            }
            else if (val == "PRO0182") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "block";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('roof_shade').style.display = "block";
                document.getElementById('homeowner').style.display = "block";
                document.getElementById('credit_score').style.display = "block";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            }
            else if (val == "PRO0183") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "none";
                document.getElementById('electric_bill_monthly').style.display = "none";
                document.getElementById('roof_shade').style.display = "none";
                document.getElementById('homeowner').style.display = "block";
                document.getElementById('credit_score').style.display = "none";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "block";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            } 
            else if (val == "PRO0141") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "none";
                document.getElementById('electric_bill_monthly').style.display = "none";
                document.getElementById('roof_shade').style.display = "none";
                document.getElementById('homeowner').style.display = "none";
                document.getElementById('credit_score').style.display = "none";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            }
            else if (val == "PRO0156") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "none";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('street').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "none";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('roof_shade').style.display = "none";
                document.getElementById('homeowner').style.display = "none";
                document.getElementById('credit_score').style.display = "none";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "block";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            }
            else if (val == "PRO0203") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('street').style.display = "none";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "block";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('roof_shade').style.display = "none";
                document.getElementById('homeowner').style.display = "none";
                document.getElementById('credit_score').style.display = "block";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";
                document.getElementById('city').style.display = "block";
                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            }
            else if (val == "PRO0180") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "none";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('street').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "none";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('roof_shade').style.display = "none";
                document.getElementById('homeowner').style.display = "none";
                document.getElementById('credit_score').style.display = "none";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "block";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            }
            else if (val == "PRO0208") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "none";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('street').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "none";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('roof_shade').style.display = "none";
                document.getElementById('homeowner').style.display = "none";
                document.getElementById('credit_score').style.display = "none";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "block";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            }
            else if (val == "PRO0207") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "none";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('street').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "none";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('roof_shade').style.display = "none";
                document.getElementById('homeowner').style.display = "none";
                document.getElementById('credit_score').style.display = "none";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "block";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            } 
            else if (val == "PRO0187") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('street').style.display = "none";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "none";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('roof_shade').style.display = "none";
                document.getElementById('homeowner').style.display = "none";
                document.getElementById('credit_score').style.display = "none";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";
                document.getElementById('company').style.display = "block";
                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            } 
            else if (val == "PRO0179") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('street').style.display = "none";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('electric_provider').style.display = "none";
                document.getElementById('electric_bill_monthly').style.display = "none";
                document.getElementById('roof_shade').style.display = "none";
                document.getElementById('homeowner').style.display = "none";
                document.getElementById('credit_score').style.display = "block";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            } 
            else if (val == "PRO0206") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('street').style.display = "none";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('city').style.display = "block";
                document.getElementById('electric_provider').style.display = "none";
                document.getElementById('electric_bill_monthly').style.display = "none";
                document.getElementById('roof_shade').style.display = "none";
                document.getElementById('homeowner').style.display = "none";
                document.getElementById('credit_score').style.display = "none";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";

                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "block";
                
            }
            else if (val == "FE0007") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('smoker').style.display = "block";
                document.getElementById('beneficiary').style.display = "block";
                document.getElementById('age').style.display = "block";
                document.getElementById('coverage').style.display = "block";
                document.getElementById('major_health_issues').style.display = "block";
                document.getElementById('electric_provider').style.display = "none";
                document.getElementById('electric_bill_monthly').style.display = "none";
                document.getElementById('roof_shade').style.display = "none";
                document.getElementById('homeowner').style.display = "none";
                document.getElementById('credit_score').style.display = "none";
                document.getElementById('credit_rating').style.display = "none";
                document.getElementById('notes').style.display = "none";
                document.getElementById('app_date_time').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
            } else if (val == "PRO0098" || val == "PRO0153") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";
                document.getElementById('call_url').style.display = "none";
                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('appt').style.display = "none";
				
				// if(document.getElementById('JornayaIDSolarT').value=="" || document.getElementById('JornayaIDSolarT').value==null){			
				// 	var leadID = document.getElementById('leadid_token').value;
					//alert(leadID);
                	// document.getElementById('JornayaIDSolarT').value=leadID;
				// }
                
                // document.getElementById('state_solar_trinity').style.display = "block";
                // document.getElementById('electric_solar_trinity').style.display = "block";

                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                document.getElementById('electric_provider').style.display = "block";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('roof_shade').style.display = "block";
                document.getElementById('homeowner').style.display = "block";
                document.getElementById('credit_score').style.display = "block";
                document.getElementById('credit_rating').style.display = "block";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            } else if (val == "PRO0075" || val == "PRO0097") {
                document.getElementById("submit").style.display = "block";
                document.getElementById('first_name').style.display = "block";


                document.getElementById('call_url').style.display = "block";

                document.getElementById('last_name').style.display = "block";
                document.getElementById('agent_name').style.display = "none";
                document.getElementById('email').style.display = "block";
                document.getElementById('phone').style.display = "block";
                document.getElementById('address').style.display = "block";
                document.getElementById('state').style.display = "block";
                document.getElementById('zip_code').style.display = "block";
                document.getElementById('smoker').style.display = "none";
                document.getElementById('beneficiary').style.display = "none";
                document.getElementById('age').style.display = "none";
                document.getElementById('coverage').style.display = "none";
                document.getElementById('major_health_issues').style.display = "none";
                document.getElementById('electric_provider').style.display = "block";
                document.getElementById('electric_bill_monthly').style.display = "block";
                document.getElementById('roof_shade').style.display = "block";
                document.getElementById('homeowner').style.display = "block";
                document.getElementById('credit_score').style.display = "block";
                document.getElementById('credit_rating').style.display = "block";
                document.getElementById('notes').style.display = "block";
                document.getElementById('app_date_time').style.display = "none";
                // document.getElementById('state_solar_trinity').style.display = "none";
                // document.getElementById('electric_solar_trinity').style.display = "none";
                document.getElementById('house_type').style.display = "none";
                document.getElementById('income').style.display = "none";
                document.getElementById('monthly_payment').style.display = "none";
                document.getElementById('appt').style.display = "none";
            }
        }
    function setWebLink() {
      window.open("https://lumio-com.chilipiper.com/book/partner-meetings/all", "_blank");
    }
    </script>

<script id="LeadiDscript" type="text/javascript">
        (function() {
        var s = document.createElement('script');
        s.id = 'LeadiDscript_campaign';
        s.type = 'text/javascript';
        s.async = true;
        s.src = '//create.lidstatic.com/campaign/bf7f77bd-face-feed-cafe-bcb51cf20276.js?snippet_version=2';
        var LeadiDscript = document.getElementById('LeadiDscript');
        LeadiDscript.parentNode.insertBefore(s, LeadiDscript);
        })();
</script>
<!-- TrustedForm -->
<script type="text/javascript">
(function() {
var tf = document.createElement('script');
tf.type = 'text/javascript'; tf.async = true;
tf.src = ("https:" == document.location.protocol ? 'https' : 'http') + "://api.trustedform.com/trustedform.js?field=xxTrustedFormCertUrl&l=" + new Date().getTime() + Math.random();
var s = document.getElementsByTagName('script')[19]; s.parentNode.insertBefore(tf, s);
document.getElementById("optin_cert").value = s.src;
})();
</script>


<noscript>
<img src="https://api.trustedform.com/ns.gif" />
</noscript>
<!-- End TrustedForm -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"> </script>
     
<script>   
    // var ip='';        
    // $.getJSON("https://api.ipify.org?format=json", function(data) {          
    //     document.getElementById('ip_address').value = data.ip;
    //     console.log(data);
    // });
    
    
</script>
<noscript><img src='//create.leadid.com/noscript.gif?lac=BF7F77BD-87EC-7538-6E77-BCB51CF20276&lck=bf7f77bd-face-feed-cafe-bcb51cf20276&snippet_version=2' /></noscript>
@endpush
