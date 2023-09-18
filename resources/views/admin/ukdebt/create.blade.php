@extends('admin.layouts.app', ['current_page' => 'Uk-Debt'])

@section('content')
@push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('dss.index') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="arrow-left" stroke-width="3" width="12"></i> Go Back</a>
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' => 'Uk-Debt'])
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
                        
                             <div class="col-2">
                                 <h3 class="mb-0 text text-danger" id="recordNotFoundLabel" style="display: none; color:white">Record Not
                                     Found</h3>
                             </div>
                             <div class="col-2">
                                 <h3 class="mb-0 text text-danger" id="alreadyASaleLabel" style="display: none; color:white">Already a Sale</h3>
                             </div>
                             <div class="col-3 ">
                                 <input style="color: black" style="border: 2px solid;" type="text" id="search"
                                     name="search" class="form-control" placeholder="Record ID">
                             </div>
                             <div class="col-2 ">
                                 <a href="#" onclick="searchRecord()" class="btn btn-primary float-right">Search
                                     Record</a>
                             </div>
                         </div>
                        @if ($errors->any())
                            <div class="alert alert-danger"style="color: red;">
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
                        <form action="{{ route('ukdebt.store') }}" method="POST" id="webform">
                            @csrf


                            <input style="color: black" type="hidden" name="record_id" id="record_id">
                            
                            <div class="row">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->HRMSID ?? 0 }}">
                                <input style="color: black" type="hidden" name="client_id" value="65">
                                <input style="color: black" type="hidden" name="campaign_id" value="3">
                                <input style="color: black" type="hidden" name="client_code" value="CUS-100078">
                                <input style="color: black" type="hidden" name="project_code" value="PRO0186">
                                
                                  <div class="form-group col-md-6" style="display: block" id="client">
                                    <span class="details">Client</span>
                                    <select required name="client" class="form-control">
                                        <option value="">Select Client</option>
                                        <option Value="DMP"> DMP </option>
                                        <option Value="IVA"> IVA </option>
                                        
                                    </select>
                                </div> 
                                <div class="form-group col-md-6">
                                    <span class="details">First Name</span>
                                    <input style="color: black" required type="text" name="first_name" id="first_name"
                                        class="form-control" placeholder="First name">
                                </div>
                                <div class="form-group col-md-6">
                                    <span class="details">Last Name</span>
                                    <input style="color: black"  type="text" name="last_name" id="last_name"
                                        class="form-control" placeholder="Last Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <span class="details">Email</span>
                                    <input style="color: black" required type="text" name="email" id="email"
                                        class="form-control" placeholder="Email">
                                </div>
                                <div class="form-group col-md-6">
                                    <span class="details">Phone</span>
                                    <input style="color: black"   type="text" name="phone" id="phone"
                                        class="form-control" placeholder="Phone">
                                </div>
                                <div class="form-group col-md-6">
                                    <span class="details">Debt Amount</span>
                                    <input style="color: black" required type="text" name="debt_amount" id="debt_amount"
                                        class="form-control" placeholder="Debt Amount">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="no_of_creditors">
                                    <span class="details">Number of Creditors </span>
                                    <select required name="num_of_creditors" class="form-control">
                                        <option value="">Select Creditors</option>
                                        <option Value="1"> 1 </option>
                                        <option Value="2"> 2 </option>
                                        <option Value="3"> 3+</option>
                                        
                                    </select>
                                </div> 
                                <div class="form-group col-md-6">
                                <span class="details">Monthly Income</span>
                                    <input style="color: black" required type="text" name="monthly_income" id="monthly_income"
                                        class="form-control" placeholder="Monthly Income">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="house_type">
                                    <span class="details">House Type </span>
                                    <select required name="house_type" class="form-control">
                                        <option value="">Select House</option>
                                        <option Value="Homeowner"> Homeowner </option>
                                        <option Value="Renting"> Renting </option>
                                    
                                    </select>
                                </div> 
                                <div class="form-group col-md-6">
                                <span class="details">Rent Amount</span>
                                    <input style="color: black" required type="text" name="rent_amount" id="rent_amount"
                                        class="form-control" placeholder="Rent Amount">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="emp_status">
                                    <span class="details">Employment Status </span>
                                    <select required name="emp_status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option Value="Employed"> Employed </option>
                                        <option Value="Self-Employed"> Self-Employed </option>
                                        
                                        
                                    </select>
                                </div> 
                                <div class="form-group col-md-6">
                                    <span class="details">Notes</span>
                                    <input style="color: black" required type="text" name="notes"
                                        class="form-control" placeholder="Notes">
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

<script>
    function searchRecord() {
        $('#loader').show();
        $('#searchForm').hide();
        $('#webform').hide();
        var id = document.getElementById('search').value;
        if (id) {
            document.getElementById('search').style.border = "2px solid lightgray";
            var request = $.ajax({
                url: "{{ url('/search_record') }}",
                type: "GET",
                data: {
                    record_id: id,
                    'table':"uk_debt"
                },
                dataType: "JSON",
                success: function(res) {
                    $('#loader').hide();
                    $('#searchForm').show();
                    if(res.status==204){
                        $('#webform').hide();
                        $('#alreadyASaleLabel').show();
                    }
                    if(res.status==200){
                        $('#webform').show();
                        $('#alreadyASaleLabel').hide();
                    }

                    if (res.data) {

                        // alert(res.data.ID);
                        document.getElementById('record_id').value = res.data.ID;
                        document.querySelector("input[name=first_name]").value = res.data.FirstName;
                        document.querySelector("input[name=last_name]").value = res.data.LastName;
                        document.querySelector("input[name=email]").value = res.data.Email;
                        document.querySelector("input[name=city]").value = res.data.City;
                        document.querySelector("input[name=state]").value = res.data.State;
                        document.querySelector("input[name=phone]").value = res.data.Phone;
                        document.querySelector("input[name=zip_code]").value = res.data.ZipCode;
                        document.querySelector("input[name=address]").value = res.data.PriAddress;
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
                        // document.querySelector("input[name=email]").value = "";
                        document.querySelector("input[name=city]").value = "";
                        document.querySelector("input[name=state]").value = "";
                        document.querySelector("input[name=phone]").value = "";
                        document.querySelector("input[name=zip_code]").value = "";
                        document.querySelector("input[name=address]").value = "";
                    }

                }
            });
        } else {
            document.getElementById('search').style.border = "2px solid #e65939";
        }

    }
</script>
 <!-- @push('js')
    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var id = $(this).val();
                $.ajax({
                    url: 'get-record-id/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response)
                        record = response.data
                        $("#first_name").val(record.first_name)
                        $("#last_name").val(record.last_name)
                        $("#record_id").val(record.id)
                        $("#customer_no").val(record.customer_no)
                        $("#area").val(record.area)
                        $("#address").val(record.address)
                        $("#city").val(record.city)
                        $("#state").val(record.state)
                        $("#zipcode").val(record.zipcode)
                        $("#phone").val(record.phone)
                        $("#email").val(record.email)
                        $("#customer_name").val(record.customer_name)
                    }
                })
            });
        });
        function getQuestionValue(val)
        {
         if (val==="yes")
         {
            document.getElementById('question_3_1').style.display = "block";
            document.getElementById('question_3_2').style.display = "block";
         }
         else
         {
            document.getElementById('question_3_1').style.display = "none";
            document.getElementById('question_3_2').style.display = "none";
         }

        }
    </script>
@endpush  -->