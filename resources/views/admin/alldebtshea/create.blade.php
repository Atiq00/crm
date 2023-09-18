@extends('admin.layouts.app', ['current_page' => 'alldebshea_external'])

@section('content')

@push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('alldebshea_external.create') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="arrow-left" stroke-width="3" width="12"></i> Go Back</a>
        </div>
    @endpush
    @include('admin.layouts.headers.cards', ['title' => 'AllDebtShea_External'])
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
                                <div class="alert alert-success" style="color: white" >
                                    {{ $message }}
                                </div>
                            </div>
                        @endif
                        <form action="{{ route('alldebshea_external.store') }}" method="POST" id="webform">
                            @csrf 
                            <div class="row">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->HRMSID ?? 0 }}">
                                <div class="form-group col-md-6" style="display: block" id="first_name">
                                    <span class="details">First name</span>
                                    <input style="color: black" required   type="text" name="first_name"
                                        data-id="first_name" class="form-control" placeholder="First name">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="last_name">
                                    <span class="details">Last name</span>
                                    <input style="color: black" required   type="text" name="last_name"
                                        data-id="last_name" class="form-control" placeholder="Last name">
                                </div> 
                                <div class="form-group col-md-6" style="display: block" id="phone">
                                    <span class="details">Phone</span>
                                    <input style="color: black" required  type="text" name="phone"
                                        data-id="phone" class="form-control" placeholder="Phone">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="address">
                                    <span class="details">Address</span>
                                    <input style="color: black" required   type="text" name="address"
                                        data-id="address" class="form-control" placeholder="Address">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="city">
                                    <span class="details">City</span>
                                    <input style="color: black" required   type="text" name="city"
                                        data-id="city" class="form-control" placeholder="City">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="state">
                                    <span class="details">State</span>
                                    <input style="color: black" required   type="text" name="state"
                                        data-id="state" class="form-control" placeholder="state">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="zipcode">
                                    <span class="details">Zip Code</span>
                                    <input style="color: black" type="text" name="zipcode" data-id="zipcode"
                                        class="form-control"   placeholder="Zip Code">
                                </div>

                                <div class="form-group col-md-6" style="display: block" id="debt">
                                    <span class="details">DEBT</span>
                                    <input style="color: black" type="text" name="debt" data-id="debt"
                                        class="form-control"   placeholder="Debt">
                                </div>
                                 
                                <div class="form-group col-md-6" style="display: block" id="notes">
                                    <span class="details">Notes</span>
                                    <textarea style="color: black" rows="3" name="notes" data-id="notes" class="form-control"
                                        placeholder="Notes"></textarea>
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
        $(document).ready(() => {
            $('#basic-datatable').DataTable();
        });
    </script>
    <!-- <script>
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
						'table':"home_warranty_external"
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
                            // document.querySelector("input[name=email]").value = res.data.Email;
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
    </script> -->
@endpush
