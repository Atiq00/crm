@extends('admin.layouts.app', ['current_page' => 'home-warranties-submission'])

@section('content')
    @include('admin.layouts.headers.cards', ['title' => 'Home-Warranty'])
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
                                <h3 class="mb-0">Home Warranty</h3>
                            </div>
                        </div>
                        <form {{-- action="{{ route('home-warranties.update',$home_warranty) }}" method="POST" --}} id="webform">
                            {{-- @csrf
                            @method('PUT') --}}
                            <div class="row">
                                <input type="hidden" name="hrms_id" value="{{ $home_warranty->hrms_id }}">
                                <div class="form-group col-md-6" style="display: block" id="first_name">
                                    <span class="details">First name</span>
                                    <input style="color: black" required type="text" name="first_name"
                                        data-id="first_name" value="{{ $home_warranty->first_name }}" class="form-control"
                                        placeholder="First name" readonly>
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="last_name">
                                    <span class="details">Last name</span>
                                    <input style="color: black" required type="text" name="last_name" data-id="last_name"
                                        value="{{ $home_warranty->last_name }}" class="form-control" placeholder="Last name"
                                        readonly>
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="phone">
                                    <span class="details">Phone</span>
                                    <input style="color: black" required type="text" name="phone" data-id="phone"
                                        class="form-control" placeholder="Phone" value="{{ $home_warranty->phone }}"
                                        readonly>
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="address">
                                    <span class="details">Address</span>
                                    <input style="color: black" required type="text" name="address" data-id="address"
                                        class="form-control" placeholder="Address" value="{{ $home_warranty->address }}"
                                        readonly>
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="city">
                                    <span class="details">City</span>
                                    <input style="color: black" required type="text" name="city" data-id="city"
                                        class="form-control" placeholder="City" value="{{ $home_warranty->city }}" readonly>
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="state">
                                    <span class="details">State</span>
                                    <input style="color: black" required type="text" name="state" data-id="state"
                                        class="form-control" placeholder="state" value="{{ $home_warranty->state }}"
                                        readonly>
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="zip_code">
                                    <span class="details">Zip Code</span>
                                    <input style="color: black" type="text" name="zip_code" data-id="zip_code"
                                        class="form-control" placeholder="Zip Code" value="{{ $home_warranty->zip_code }}"
                                        readonly>
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="client">
                                    <span class="details">Client</span>
                                    <input style="color: black" type="text" name="client" data-id="client"
                                        class="form-control" placeholder="client" value="{{ $home_warranty->client }}"
                                        readonly>
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="notes">
                                    <span class="details">Notes</span>
                                    <textarea style="color: black" rows="3" name="notes" data-id="notes" class="form-control"
                                        placeholder="Notes" readonly>{{ $home_warranty->notes }}</textarea>
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="client">
                                    <span class="details">Status</span>
                                    <input style="color: black" type="text" name="status" data-id="status"
                                        class="form-control" placeholder="status" value="{{ $home_warranty->status }}"
                                        readonly>
                                </div>

                                {{-- <div class="form-group col-md-6" id="submit"
                                    style="display: block; margin-top: -8px;">
                                    <label for="">&nbsp;</label>
                                    <input style="color: black" type="submit" class="btn btn-info btn-block"
                                        value="Submit">
                                </div> --}}
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
    {{--     <script>
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
                        record_id: id
                    },
                    dataType: "JSON",
                    success: function(res) {
                        $('#loader').hide();
                        $('#searchForm').show();
                        $('#webform').show();
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
                                message: 'Record Does not Exist',
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
            } else {
                document.getElementById('search').style.border = "2px solid #e65939";
            }

        }
    </script> --}}
@endpush
