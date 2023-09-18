@extends('admin.layouts.app', [ 'current_page' => 'tbb-submission ' ])

@section('content')


    @include('admin.layouts.headers.cards', ['title' => "tbb-submission"])

    @php

        $start_date = '';
        $end_date = '';
        $phone = '';

        if (isset($_GET['search'])) {
            if (!empty($_GET['start_date'])) {
                $start_date = $_GET['start_date'];
            }
            if (!empty($_GET['end_date'])) {
                $end_date = $_GET['end_date'];
            }
        }
        if (isset($_GET['search'])) {
            if (!empty($_GET['phone'])) {
                $phone = $_GET['phone'];
            }
        }
    @endphp

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <h3 class="mb-0">Manage TBB Stats</h3>
                            </div>
                            <div class="col-3">
                                <a href="{{route('tbb.create')}}" class="btn btn-info float-right m-1">TBB-Form </a>
                                @if (isset($_GET['search']))
                                    <a href="{{ route('tbb.sales-report') }}?start_date={{ $start_date }}&end_date={{ $end_date }}"
                                        class="btn btn-info float-right">Export</a>
                                @else
                                    <a href="{{ route('tbb.sales-report') }}"
                                        class="btn btn-info float-right m-1">Export</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div>
                        <form action="{{ route('tbb.index') }}" method="GET" class="search p-3">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="search" value="1">
                                <div class="col-md-3">
                                    <span class="details">Start Date</span>
                                    <input type="date" name="start_date" value="{{ $start_date }}" class="form-control"
                                        placeholder="Start Date">
                                </div>
                                <div class="form-group col-md-3">
                                    <span class="details">End Date</span>
                                    <input type="date" name="end_date" value="{{ $end_date }}" class="form-control"
                                        placeholder="End Date">
                                </div>
                                <div class="col-md-1" style="margin-top: -8px;">
                                    <label for="">&nbsp;</label>
                                    <input style="color: white" type="submit" class="btn btn-info btn-block"
                                        value="Search">
                                </div>
                                {{-- <div class="col-md-1" style="margin-top: -8px;">
                                    <label for="">&nbsp;</label>
                                    <input type="submit" value="Export CSV" name="export" class="form-control btn btn-info" >
                                </div> --}}
                                <div>
                        </form>
                    </div>
                    <table class="table align-items-center table-flush" id="">
                        <thead class="thead-light">
                            <tr>

                                <th scope="col">Top-Performer</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tbb2 as $row)

                                <tr>
                                    <td>{{$row->agent}}</td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="table align-items-center table-flush" id="">
                        <thead class="thead-light">
                            <tr>

                                <th scope="col">Total-Achievement</th>
                                <th scope="col">Total-Live+Test-Request</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tbb as $row)

                                <tr>
                                    <td>{{round($row->avg,2)}}%</td>
                                    <td>{{$row->totalcount}}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="table-responsive pb-3">
                        @include('admin.tbbstats.sales-report')
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

        <form action="#" method="post" id="FORM_DELETE">
            @csrf
            @method('DELETE')
        </form>
     @endpush
