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
                                <h3 class="mb-0 text text-danger" id="alreadyASaleLabel" style="display: none">Already a
                                    Sale</h3>
                            </div>
                            <div class="col-3 ">
                                <input style="color: black" style="border: 2px solid;" type="number" id="search"
                                    name="search" class="form-control" placeholder="Record ID or Phone #">
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
                        <form action="{{ route('solars.store') }}" method="POST" id="webform">
                            @csrf


                            <input style="color: black" type="hidden" name="lead_id" id="leadid_token" class="form-control"
                                placeholder="leadid_token">

                            <input style="color: black" type="hidden" name="optin_cert" id="optin_cert"
                                class="form-control">
                            <input style="color: black" type="hidden" name="record_id" id="record_id">
                            <input style="color: black" type="hidden" name="JornayaIDSolarT" id="JornayaIDSolarT">
                            <div class="row">
                                <div class="form-group col-md-6" style="display: block;" id="clients">
                                    <b class="details">Select Client</b>
                                    <select name="clients" id="ddclients" required onchange="selectClient(this.value)"
                                        class="form-control selection_style" style=" background: lightblue; color: black;">
                                        <option value="">Select </option>
                                        @foreach ($projects as $row)
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
                                <div class="form-group col-md-6" style="display: none" id="income">
                                    <span class="details">Income</span>
                                    <input style="color: black" type="text" name="income" class="form-control"
                                        placeholder="Income">

                                </div>
                                <div class="form-group col-md-6" style="display: none" id="call_url">
                                    <span class="details">Call Recording url</span>
                                    <input type="url" name="call_url" class="form-control">
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
                </div>
            </div>
        </div>
        @include('admin.layouts.footers.auth')
    </div>
@endsection
@push('js')
    <script>
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
                        document.getElementById("electric_bills_monthly").value = res.data.ElectricBill;
                        document.getElementById("electric_providers").value = res.data.ElectricProvider;
                        document.getElementById("CreditScore").value = res.data.CreditScore;
                        document.getElementById('st').value = res.data.State;
                        if (res.data.Client_id == 42) {
                            document.getElementById("electric_providers").innerHTML = "<option>" + res.data
                                .ElectricProvider + "</option>";
                            document.getElementById('st').innerHTML = "<option>" + res.data.State + "</option>";
                            document.getElementById('JornayaIDSolarT').value = res.data.JornayaID;
                        } else {
                            document.getElementById('JornayaIDSolarT').value = "";
                        }
                    } else {
                        $.notify({
                            message: res.data.message,
                            icon: 'ni ni-fat-remove',
                        }, {
                            type: 'danger',
                            offset: 50,
                        });
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
       
        function selectClient(val) {
            document.getElementById("content").innerHTML='<object type="text/html" data="home.html" ></object>';
        }
    </script>

    <!--Script for SolarLG-->
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
            tf.type = 'text/javascript';
            tf.async = true;
            tf.src = ("https:" == document.location.protocol ? 'https' : 'http') +
                "://api.trustedform.com/trustedform.js?field=xxTrustedFormCertUrl&ping_field=xxTrustedFormPingUrl&l=" +
                new Date().getTime() + Math.random();
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(tf, s);
            document.getElementById("optin_cert").value = s.src;
        })();
    </script>
    <noscript>
        <img src="https://api.trustedform.com/ns.gif" />
    </noscript>
    <!-- End TrustedForm -->



    <script>
        // var ip='';        
        // $.getJSON("https://api.ipify.org?format=json", function(data) {          
        //     document.getElementById('ip_address').value = data.ip;
        //     console.log(data);
        // });
    </script>
    <noscript><img
            src='//create.leadid.com/noscript.gif?lac=BF7F77BD-87EC-7538-6E77-BCB51CF20276&lck=bf7f77bd-face-feed-cafe-bcb51cf20276&snippet_version=2' /></noscript>

    <!--Script for SolarLG-->
@endpush
