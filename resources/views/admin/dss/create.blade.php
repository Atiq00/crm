@extends('admin.layouts.app', ['current_page' => 'dss'])

@section('content')
@push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('dss.index') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="arrow-left" stroke-width="3" width="12"></i> Go Back</a>
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' => 'DSS'])
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
                            <div class="col-5">
                                <h3 class="mb-0">DSS sale Submission</h3>
                            </div>
                            <div class="col-4">
                                <h3 class="mb-0 text text-danger" id="recordNotFoundLabel" style="display: none">Record Not
                                    Found</h3>
                            </div>
                            <!-- <div class="col-3">
                                <input style="color: black" style="border: 2px solid;" type="text"  id="search"
                                    name="search" class="form-control" placeholder="Record ID">
                            </div> -->
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
                        <form action="{{ route('dss.store') }}" method="POST">
                            @csrf


                            <input style="color: black" type="hidden" name="record_id" id="record_id">
                            <div class="row">
                                <input type="hidden" name="hrms_id" value="{{ Auth::user()->HRMSID ?? 0 }}">
                                <input style="color: black" type="hidden" name="client_id" value="18">
                                <input style="color: black" type="hidden" name="campaign_id" value="95">
                                <input style="color: black" type="hidden" name="client_code" value="CUS-100031">
                                <input style="color: black" type="hidden" name="project_code" value="PRO0091">
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
                                    <span class="details">Customer Number</span>
                                    <input style="color: black" required type="text" name="customer_no" id="customer_no"
                                        class="form-control" placeholder="Customer Number">
                                </div>
                                <div class="form-group col-md-6">
                                    <span class="details">Address</span>
                                    <input style="color: black" required type="text" name="address" id="address"
                                        class="form-control" placeholder="Address">
                                </div>
                                <div class="form-group col-md-6">
                                    <span class="details">City</span>
                                    <input style="color: black" required type="text" name="city" id="city"
                                        class="form-control" placeholder="City">
                                </div>
                                <div class="col-md-6 col-lg-6 form-group" style="display: block" id="state">
                                        <span class="details">State</span>
                                        <select name="state" id="st" readonly class="form-control selection_style">
                                            <option>AL</option>
                                            <option>AK</option>
                                            <option>AZ</option>
                                            <option>AR</option>
                                            <option>CA</option>
                                            <option>CO</option>
                                            <option>CT</option>
                                            <option>DE</option>
                                            <option>FL</option>
                                            <option>GA</option>
                                            <option>HI</option>
                                            <option>ID</option>
                                            <option>IL</option>
                                            <option>IN</option>
                                            <option>IA</option>
                                            <option>KS</option>
                                            <option>KY</option>
                                            <option>LA</option>
                                            <option>ME</option>
                                            <option>MD</option>
                                            <option>MA</option>
                                            <option>MI</option>
                                            <option>MN</option>
                                            <option>MS</option>
                                            <option>MO</option>
                                            <option>MT</option>
                                            <option>NE</option>
                                            <option>NV</option>
                                            <option>NH</option>
                                            <option>NJ</option>
                                            <option>NM</option>
                                            <option>NY</option>
                                            <option>NC</option>
                                            <option>ND</option>
                                            <option>OH</option>
                                            <option>OK</option>
                                            <option>OR</option>
                                            <option>PA</option>
                                            <option>RI</option>
                                            <option>SC</option>
                                            <option>SD</option>
                                            <option>TN</option>
                                            <option>UT</option>
                                            <option>VT</option>
                                            <option>VA</option>
                                            <option>WA</option>
                                            <option>WV</option>
                                            <option>WI</option>
                                            <option>WY</option>
                                            <option>TX</option>
                                        </select>
                                    </div>
                                <div class="form-group col-md-6">
                                    <span class="details">Zip Code</span>
                                    <input style="color: black" required type="text" name="zipcode" id="zipcode"
                                        class="form-control" placeholder="ZipCode">
                                </div>
                                <div class="form-group col-md-6">
                                    <span class="details">Phone</span>
                                    <input style="color: black"   type="text" name="phone" id="phone"
                                        class="form-control" placeholder="Phone">
                                </div>
                                <div class="form-group col-md-6">
                                    <span class="details">Email</span>
                                    <input style="color: black" required type="text" name="email" id="email"
                                        class="form-control" placeholder="Email">
                                </div>
                                <div class="form-group col-md-6">
                                    <span class="details">Area</span>
                                    <input style="color: black" required type="text" name="area" id="area"
                                        class="form-control" placeholder="Area">
                                </div>
                                <div class="form-group col-md-6">

                                    <span class="details">From which vendor do you usually buy or supplies from?</span>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Amazon"
                                            name="question_1[]">
                                        <label class="form-check-label">
                                            Amazon
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" value="Beckers" type="checkbox"
                                            name="question_1[]">
                                        <label class="form-check-label">
                                            Beckers
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" value="Lakeshore" type="checkbox"
                                            name="question_1[]">
                                        <label class="form-check-label">
                                            Lakeshore 
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" value="Kaplan" type="checkbox"
                                            name="question_1[]">
                                        <label class="form-check-label">
                                            Kaplan
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" value="Discountschoolsupply" type="checkbox"
                                            name="question_1[]">
                                        <label class="form-check-label">
                                            Discount school supply
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" value="Schoolspeciality" type="checkbox"
                                            name="question_1[]">
                                        <label class="form-check-label">
                                            School speciality
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" value="OrientalTrading" type="checkbox"
                                            name="question_1[]">
                                        <label class="form-check-label">
                                            Oriental Trading
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" value="UsemultipleVendor" type="checkbox"
                                            name="question_1[]">
                                        <label class="form-check-label">
                                            Use multiple Vendor
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <span class="details">What was the reason for you to purchase your supplies from other
                                        supplies?</span>

                                    <div class="form-check">
                                        <input class="form-check-input" value="Pricing" type="checkbox"
                                            name="question_2[]">
                                        <label class="form-check-label">
                                            Pricing
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" value="Lackofproducts" type="checkbox"
                                            name="question_2[]">
                                        <label class="form-check-label">
                                            Lack of products
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" value="FastShipping" type="checkbox"
                                            name="question_2[]">
                                        <label class="form-check-label">
                                            Fast Shipping
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" value="FreeShipping" type="checkbox"
                                            name="question_2[]">
                                        <label class="form-check-label">
                                            Free Shipping
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" value="Quality" type="checkbox"
                                            name="question_2[]">
                                        <label class="form-check-label">
                                            Quality
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" value="CustomerService" type="checkbox"
                                            name="question_2[]">
                                        <label class="form-check-label">
                                            Customer Service
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" value="HappywithDss" type="checkbox"
                                            name="question_2[]">
                                        <label class="form-check-label">
                                            Happy with Dss
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <span class="details">Others Question 1</span>
                                    <input style="color: black" type="text" name="others_question_1"
                                        id="others_question_1" class="form-control" placeholder="Others Question 1">
                                </div>
                                <div class="form-group col-md-6">
                                    <span class="details">Others Question 2</span>
                                    <input style="color: black" type="text" name="others_question_2"
                                        id="others_question_2" class="form-control" placeholder="Others Question 2">
                                </div>
                                <div class="col-md-6 col-lg-6 form-group" style="display: block" id="question_3">
                                    <span class="details">Are you planning to add any new Classrooms in the near future?</span>
                                    <select name="question_3" id="q_3" class="form-control selection_style" onchange="getQuestionValue(this.value)">
                                        <option >Select</option>
                                        <option value="yes" >Yes</option>
                                        <option value="no">No</option>

                                    </select>
                                    </div>
                                    <div class="col-md-6 col-lg-6 form-group" id="question_3_1" style="display: none">
                                        <span class="details">Are you refurbishing or creating / constructing new ones?</span>
                                        <select name="question_3_1" id="q_3_1" class="form-control selection_style">
                                            <option >Select</option>
                                            <option value="REFURBISHING" >REFURBISHING</option>
                                            <option value="NEW ADDITION">NEW ADDITION</option>

                                        </select>
                                        </div>
                                        <div class="col-md-6 col-lg-6 form-group" id="question_3_2" style="display: none">
                                            <span class="details">What would be the timeline, this quarter or the next?</span>
                                            <select name="question_3_2" id="q_3_2" class="form-control selection_style">
                                                <option >Select</option>
                                                <option value="1-3 months" >1-3 months</option>
                                                <option value="3-6 months">3-6 months</option>
                                                <option value="6-9 months" >6-9 months</option>
                                                <option value="A year">A year</option>
                                                <option value="Not Yet Defined">Not Yet Defined</option>
                                                <option value="No Info">No Info</option>
                                            </select>
                                            </div>
                                            <div class="col-md-6 col-lg-6 form-group" id="question_4" style="display: block">
                                            <span class="details">Do you buy Discount School Supply/Colorations brand items on Amazon?</span>
                                            <select name="question_4" id="q_4" class="form-control selection_style">
                                                <option >Select</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                            </div>
                                <div class="form-group col-md-6">
                                    <span class="details">Promo Code</span>
                                    <input style="color: black" required type="text" name="promo_code"
                                        class="form-control" placeholder="Promo Code">
                                </div>
                                <div class="form-group col-md-6">
                                    <span class="details">Customer name</span>
                                    <input style="color: black" required type="text" name="customer_name"
                                        class="form-control" placeholder="Customer name">
                                </div>
                                <div class="form-group col-md-6">
                                    <span class="details">Comments</span>
                                    <input style="color: black" required type="text" name="comments"
                                        class="form-control" placeholder="Customer name">
                                </div>

                                <input type="hidden" name="user_id" value="{{ Auth::user()->HRMSID }}">


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
@endpush
