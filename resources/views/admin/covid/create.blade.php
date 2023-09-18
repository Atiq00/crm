@extends('admin.layouts.app', ['current_page' => 'covid-submission'])

@section('content')

@push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('covid.create') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="arrow-left" stroke-width="3" width="12"></i> Go Back</a>
        </div>
    @endpush
    @include('admin.layouts.headers.cards', ['title' => 'covid-submission'])
  
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
                           <!-- <div class="col-3">
                                <h3 class="mb-0">Home Warranty Submission</h3>
                            </div> -->
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
                        <form action="{{ route('covid.store') }}" method="POST" id="webform">
                            @csrf
                            <input style="color: black" type="hidden" name="record_id" id="record_id">
							<input style="color: black" type="hidden" name="project_code" id="project_code" value="">
							<input style="color: black" type="hidden" name="client_code" id="client_code" value="">
                            <div class="row">
                                <input type="hidden" name="hrms_id" value="{{ Auth::user()->HRMSID ?? 0 }}">
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
                                        data-id="phone" class="form-control" placeholder="phone">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="medi_num">
                                    <span class="details">Medi Num</span>
                                    <input style="color: black" required   type="text" name="medi_num"
                                        data-id="medi_num" class="form-control" placeholder="Medi Num">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="dob">
                                    <span class="details">DOB</span>
                                    <input style="color: black" required   type="date" name="dob"
                                        data-id="dob" class="form-control">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="notes">
                                    <span class="details">Notes</span>
                                    <input style="color: black" required   type="text" name="notes"
                                        data-id="notes" class="form-control" placeholder="notes">
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
						'table':"covid_kit"
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
                            console.log(res.data)
                            // alert(res.data.ID);
                            document.getElementById('record_id').value = res.data.ID;
                            document.querySelector("input[name=first_name]").value = res.data.FirstName;
                            document.querySelector("input[name=last_name]").value = res.data.LastName;
                            document.querySelector("input[name=phone]").value = res.data.Phone;
                           
s;
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
    {{-- <script>
        function changethefield(val) {
            console.log(val);
            if (val == "GHW") {
                document.getElementById('closers1').style.display = "block";
				document.getElementById('project_code').value = "PRO0090";
				document.getElementById('client_code').value = "CUS-100028";
            } else if(val == "HW CH less then 59") {
				document.getElementById('project_code').value = "PRO0091";
				document.getElementById('client_code').value = "CUS-100028";
                document.getElementById('closers1').style.display = "none";
            } else if (val == "HW CH 60 Years") {
				document.getElementById('project_code').value = "PRO0092";
				document.getElementById('client_code').value = "CUS-100028";
                document.getElementById('closers1').style.display = "none";
			} else {
			document.getElementById('closers1').style.display = "none";
			}

        }

        function showInputField(val) {
            if (val == "Other") {
                document.getElementById('closers2').style.display = "block";
            } else {
                document.getElementById('closers2').style.display = "none";
            }
        }
    </script> --}}
@endpush
