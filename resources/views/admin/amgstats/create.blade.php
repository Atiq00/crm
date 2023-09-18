@extends('admin.layouts.app', ['current_page' => 'amgstats-submission'])

@section('content')

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
            <a href="{{ route('amg.create') }}" class="btn btn-sm btn-icon btn-neutral">
                <i data-feather="arrow-left" stroke-width="3" width="12"></i> Go Back</a>
        </div>
    @endpush
    @include('admin.layouts.headers.cards', ['title' => 'amgstats-submission'])
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
                                <div class="alert alert-success" style="color: white">
                                    {{ $message }}
                                </div>
                            </div>
                        @endif
                        <form action="{{ route('amg.store') }}" method="POST" id="webform">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6" style="display: block;">
                                    <b class="details">Select Reporting-To</b>
                                    <select name="reporting_to_id" id="reporting_to" required
                                        class="form-control selection_style" style=" background: lightblue; color: black;">
                                        <option value="">Select Reporting to</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->HRMSID }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6" style="display: block;">
                                    <b class="details">Agent's</b>
                                    <select name="hrms_id" id="agents" required class="form-control selection_style"
                                        style=" background: lightblue; color: black;">
                                        <option value="">Select </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="live_request_count">
                                    <span class="details">Live Request</span>
                                    <input style="color: black" required type="text" name="live_request_count"
                                        data-id="live_request_count" class="form-control" placeholder="Live Request">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="quotation_id">
                                    <span class="details">Quotation ID</span>
                                    <input style="color: black" required type="text" name="quotation_id"
                                        data-id="quotation_id" class="form-control" placeholder="Quotation ID">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="test_request_count">
                                    <span class="details">Test Request</span>
                                    <input style="color: black" required type="text" name="test_request_count"
                                        data-id="test_request_count" class="form-control" placeholder="Test Request">
                                </div>
                                <div class="form-group col-md-6" style="display: block" id="avg_time_request">
                                    <span class="details">AVG Time Request</span>
                                    <input style="color: black" required type="text" name="avg_time_request"
                                        data-id="avg_time_request	" class="form-control" placeholder="Average Time Request">
                                </div>
                                <input type="hidden" name="agent_name" id="agent_name">
                                <input type="hidden" name="reporting_to_name" id="reporting_to_name">
                                <input type="hidden" name="project_code" value="PRO0131">
                                <input type="hidden" name="client_code" value="CUS-100046">
                                <div class="form-group col-md-6" id="submit" style="display: block; margin-top: -8px;">
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
            $('#reporting_to').change(function() {
                var id = $(this).val();
                $.ajax({
                    url: 'agent-details/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response);

                        const select = document.getElementById('agents');
                        for (let i = 0; i < response.data.length; i++) {
                            const option = document.createElement('option');
                            option.value = response.data[i].HRMSID;
                            option.textContent = response.data[i].name;
                            select.appendChild(option);
                        }
                    }
                })
            });
        });
        $(document).ready(function() {
            $('#agents').change(function() {
                var id = $(this).val();
                $.ajax({
                    url: 'agent-names/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        agent = response.data
                        $("#agent_name").val(agent.name)
                        $("#reporting_to_name").val(agent.reporting_to_name)
                    }
                })
            });
        });
    </script>
@endpush
