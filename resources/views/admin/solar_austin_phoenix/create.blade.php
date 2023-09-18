@extends('admin.layouts.app', ['current_page' => 'solar-submission'])

@section('content')

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
            <a href="{{ route('austinphoenix.index') }}" class="btn btn-sm btn-icon btn-neutral">
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
                         
                        @if ($errors->any())
                            <div class="alert alert-danger" style="color: red;">
                                <strong class="text-secondary">Oops!</strong> There were some problems with your input.<br><br>
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
                        <form action="{{ route('austinphoenix.store') }}" method="POST" id="webform">
                             @csrf 
                            <div class="row">
                                <input type="hidden" name="clients" value="PRO0095">  
                                <input type="hidden" name="sol" value="1"> 
                                <input type="hidden" name="record_id" value="{{$lead->record_id}}"> 
                                <div class="form-group col-md-6" style="display: block" id="first_name">
                                    <span class="details">First name</span>
                                    <input style="color: black" required type="text" name="first_name"data-id="first_name" value="{{$lead->first_name}}" class="form-control" placeholder="First name">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="last_name">
                                    <span class="details">Last name</span>
                                    <input style="color: black" required type="text" name="last_name" data-id="last_name" value="{{$lead->last_name}}" class="form-control" placeholder="Last name">
                                </div>                                
                                <div class="form-group col-md-6" style="display: block" id="phone">
                                    <span class="details">Phone</span>
                                    <input style="color: black" type="text"  value="{{$lead->phone_number}}" name="phone" data-id="phone" class="form-control" placeholder="Phone">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="address">
                                    <span class="details">Address</span>
                                    <input style="color: black" type="text" name="address" data-id="address"  value="{{$lead->street_address}}" class="form-control" placeholder="Address">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="city">
                                    <span class="details">City</span>
                                    <input style="color: black" type="text" name="city"  value="{{$lead->city}}" data-id="city" class="form-control" placeholder="City">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="state">
                                    <span class="details">state</span>
                                    <select required onchange="slectState(this)"  value="{{$lead->state}}" name="state" id="st" class="form-control">
                                        <option value="">Select State</option>
                                        @foreach ($states as $row)
                                            <option @if($lead->state == $row->state ) selected="selected" @endif>{{ $row->state }}</option>
                                        @endforeach
                                    </select>
                                </div>  
                                <div class="form-group col-md-6" style="display: block;" id="app_date_time">
                                    <span class="details">Appointment Date</span>
                                    <input style="color: black" type="datetime-local" =""=""  value="{{$lead->date}}" name="app_date_time"  class="form-control" placeholder="Appointment Date-T-me">
                                </div>                              
                                 <div class="form-group col-md-6" style="display: block" id="electric_provider">
                                      <span class="details">Electric Provider</span>  
                                    {{--<select name="electric_providers" id="electric_providers" class="form-control">
                                        <option value="">--Select--</option>
                                    </select>   --}}
                                    <input style="color: black" type="text" name="electric_providers"  value="{{$lead->electric_providers}}" data-id="electric_providers" class="form-control" placeholder="Electric Providers">                                  
                                </div> 
                                <div class="form-group col-md-6" style="display: block" id="zip_code">
                                    <span class="details">Zip Code</span>
                                    <input  value="{{$lead->zip_code}}" style="color: black" type="text" name="zip_code" data-id="zip_code"  class="form-control" placeholder="Zip Code">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="email">
                                    <span class="details">Email</span>
                                    <input style="color: black" type="text"  value="{{$lead->email}}" name="email" data-id="email" class="form-control" placeholder="Email">
                                </div>
                                 
                                                                
                                <div class="form-group col-md-6" style="display: block" id="electric_bill_monthly">
                                    <span class="details">Electric Bill Monthly</span>
                                    <select name="electric_bill" class="form-control">
                                        <option @if($lead->average_monthly_bill == "$0-50" ) selected="selected" @endif value="$0-50">$0-50</option>
                                        <option @if($lead->average_monthly_bill == "$51-100" ) selected="selected" @endif value="$51-100">$51-100</option>
                                        <option @if($lead->average_monthly_bill == "$101-150" ) selected="selected" @endif value="$101-150">$101-150</option>
                                        <option @if($lead->average_monthly_bill == "$151-200" ) selected="selected" @endif value="$151-200">$151-200</option>
                                        <option @if($lead->average_monthly_bill == "$201-300" ) selected="selected" @endif value="$201-300">$201-300</option>
                                        <option @if($lead->average_monthly_bill == "$301-400" ) selected="selected" @endif value="$301-400">$301-400</option>
                                        <option @if($lead->average_monthly_bill == "$401-500" ) selected="selected" @endif value="$401-500">$401-500</option>
                                        <option @if($lead->average_monthly_bill == "$501-600" ) selected="selected" @endif value="$501-600">$501-600</option>
                                        <option @if($lead->average_monthly_bill == "$601-700" ) selected="selected" @endif value="$601-700">$601-700</option>
                                        <option @if($lead->average_monthly_bill == "$701-800" ) selected="selected" @endif value="$701-800">$701-800</option>
                                        <option @if($lead->average_monthly_bill == "$801+" ) selected="selected" @endif value="$801+">$801+</option>
                                    </select>
                                </div> 
                                <div class="form-group col-md-6" style="display: block" id="homeowner">
                                    <span class="details">Home Owner</span>
                                    <select name="homeowner" class="form-control">
                                        <option @if($lead->home_owner == "YES" ) selected="selected" @endif value="YES">YES</option>
                                        <option @if($lead->home_owner == "NO" ) selected="selected" @endif value="NO">NO</option>
                                        <option @if($lead->home_owner == "COMMERCIAL" ) selected="selected" @endif value="COMMERCIAL">COMMERCIAL</option>
                                        <option @if($lead->home_owner == "CONDO" ) selected="selected" @endif value="CONDO">CONDO</option>
                                        <option @if($lead->home_owner == "MOBILE HOME" ) selected="selected" @endif value="MOBILE HOME">MOBILE HOME</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="credit_score">
                                    <span class="details">Credit Score</span>
                                    <input style="color: black" type="text"  value="{{$lead->credit_score}}" name="credit_score" id="CreditScore" class="form-control" placeholder="Credit Score">
                                </div> 
                                <div class="form-group col-md-6" style="display: block" id="credit_score">
                                    <span class="details">Notes</span>
                                    <input style="color: black" type="text"  value="{{@$lead->notes}}" name="notes" id="notes" class="form-control" placeholder="Notes">
                                </div> 
                                <div class="form-group col-md-6" id="submit"
                                    style="display: block; margin-top: -8px;">
                                    <label for="">&nbsp;</label>
                                    <input style="color: black" type="submit" class="btn btn-info btn-block" value="Submit">
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
        function slectState(val){   
            $.ajax({
                url: "{{ url('/api/select_electric') }}",
                type: "GET",
                data: {val :val.value }, 
                success:function (res){  
                    if(res){
                        var options ='';
                        for(let i=0; i<res.length;i++){ 
                            let vr = (res[i].id); 
                            options +="<option>"+(res[i].electric_provider)+"</option>"; 

                        }
                        document.getElementById("electric_providers").innerHTML=options;

                    }
                }
            });  
        } 
    </script>    
@endpush
