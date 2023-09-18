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
                        <form action="{{ route('austinphoenix.store_other') }}" method="POST" id="webform">
                             @csrf 
                            <div class="row">
                                <input type="hidden" name="clients" value="PRO0095">  
                                <input type="hidden" name="other_src" value="other_src">  
                                <input type="hidden" name="sol" value="1"> 
                                <div class="form-group col-md-6" style="display: block" id="first_name">
                                    <span class="details">First name</span>
                                    <input style="color: black" required type="text" name="first_name"data-id="first_name" value="{{old('first_name')}}" class="form-control" placeholder="First name">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="last_name">
                                    <span class="details">Last name</span>
                                    <input style="color: black" required type="text" name="last_name" data-id="last_name" value="{{old('last_name')}}" class="form-control" placeholder="Last name">
                                </div>                                
                                <div class="form-group col-md-6" style="display: block" id="phone">
                                    <span class="details">Phone</span>
                                    <input style="color: black" type="text"  value="{{old('phone_number')}}" name="phone" data-id="phone" class="form-control" placeholder="Phone">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="address">
                                    <span class="details">Address</span>
                                    <input style="color: black" type="text" name="address" data-id="address"  value="{{old('street_address')}}" class="form-control" placeholder="Address">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="city">
                                    <span class="details">City</span>
                                    <input style="color: black" type="text" name="city"  value="{{old('city')}}" data-id="city" class="form-control" placeholder="City">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="state">
                                    <span class="details">state</span>
                                    <select required onchange="slectState(this)"  value="{{old('state')}}" name="state" id="st" class="form-control">
                                        <option value="">Select State</option>
                                        @foreach ($states as $row)
                                            <option>{{ $row->state }}</option>
                                        @endforeach
                                    </select>
                                </div>  
                                <div class="form-group col-md-6" style="display: block;" id="app_date_time">
                                    <span class="details">Appointment Date</span>
                                    <input style="color: black" type="datetime-local" =""=""  value="{{old('date')}}" name="app_date_time"  class="form-control" placeholder="Appointment Date-T-me">
                                </div>                              
                                 <div class="form-group col-md-6" style="display: block" id="electric_provider">
                                    <span class="details">Electric Provider</span>   
                                    <input style="color: black" type="text" name="electric_providers"  value="{{old('electric_providers')}}" data-id="electric_providers" class="form-control" placeholder="Electric Providers">                                  
                                </div> 
                                <div class="form-group col-md-6" style="display: block" id="zip_code">
                                    <span class="details">Zip Code</span>
                                    <input  value="{{old('zip_code')}}" style="color: black" type="text" name="zip_code" data-id="zip_code"  class="form-control" placeholder="Zip Code">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="email">
                                    <span class="details">Email</span>
                                    <input style="color: black" type="text"  value="{{old('email')}}" name="email" data-id="email" class="form-control" placeholder="Email">
                                </div>                          
                                <div class="form-group col-md-6" style="display: block" id="electric_bill_monthly">
                                    <span class="details">Electric Bill Monthly</span>
                                    <select name="electric_bill" class="form-control">
                                        <option>$0-50</option>
                                        <option>$51-100</option>
                                        <option>$101-150</option>
                                        <option>$151-200</option>
                                        <option>$201-300</option>
                                        <option>$301-400</option>
                                        <option>$401-500</option>
                                        <option>$501-600</option>
                                        <option>$601-700</option>
                                        <option>$701-800</option>
                                        <option>$801+</option>
                                    </select>
                                </div> 
                                <div class="form-group col-md-6" style="display: block" id="homeowner">
                                    <span class="details">Home Owner</span>
                                    <select name="homeowner" class="form-control">
                                        <option>YES</option>
                                        <option>NO</option>
                                        <option>COMMERCIAL</option>
                                        <option>CONDO</option>
                                        <option>MOBILE HOME</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6" style="display: block">
                                    <span class="details">Credit Score</span>
                                    <input style="color: black" type="text"  value="{{old('credit_score')}}" name="credit_score" id="CreditScore" class="form-control" placeholder="Credit Score">
                                </div> 
                                <div class="form-group col-md-6" style="display: block">
                                    <span class="details">Notes</span>
                                    <input style="color: black" type="text"  value="{{old('notes')}}"  name="notes" id="notes" class="form-control" placeholder="Notes">
                                </div> 
                                <div class="form-group col-md-6" style="display: block">
                                    <span class="details">Property</span>
                                    <input style="color: black" type="text"  value="{{old('property')}}"  name="property" id="property" class="form-control" placeholder="Property">
                                </div> 
                                <div class="form-group col-md-3" style="display: block">
                                    <span class="details">Source</span>
                                    <select name="type" required id="" class="form-control">
                                        <option value="Email">--Select--</option>
                                        <option value="Email">Email</option>
                                        <option value="Phone_Call">Phone_Call</option>
                                    </select>
                                </div> 
                                <div class="form-group col-md-3" id="submit"
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
