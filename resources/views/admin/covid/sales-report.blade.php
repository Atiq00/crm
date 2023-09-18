<table class="table align-items-center table-flush">
    <thead class="thead-light">
        <tr>
           <th scope="col">No</th>

            <th scope="col">Created Date</th>
            <th scope="col">HRMS ID</th>
			 <th scope="col">Pseudonym</th>
			<th scope="col">RecordID</th>
            <!--<th scope="col">Agent Name</th>-->
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Phone</th>
            @if(auth()->user()->hasRole('Super Admin'))
            <th scope="col">Phone</th>
            @endif
            <th scope="col">QA-status</th>
            <th scope="col">Client-status</th>
            <th scope="col">ReportingTo</th>
            <th scope="col">Project</th>
        </tr>
    </thead>
    <tbody>
        @if (count($covid) > 0)
            @foreach ($covid as $data)
                <tr>
                    <!-- {{ ($data->reporting ) }} -->
                    <td>{{$loop->iteration}}</td>
                    <td width="3%">{{ $data->created_at ?? '' }}</td>
                    <td width="3%">{{ $data->hrms_id ?? '' }}</td>
					<td width="3%">{{ $data->agent_detail->pseudo_name ?? '' }}-{{ $data->agent_detail->name ?? '' }}</td>
					<td width="3%">{{ $data->record_id ?? '' }}</td>
                    {{-- <!--<td>{{ $home_warranty->agent_detail->name ?? '' }}</td>--> --}}
                    <td width="3%">{{ $data->first_name ?? '' }}</td>
                    <td width="3%">{{ $data->last_name ?? '' }}</td>
                    <td width="3%">{{substr($data->phone, 0, 3) }}***{{ substr($data->phone,-4) }}</td>
                    @if(auth()->user()->hasRole('Super Admin'))
                    <td width="3%">{{$data->phone }}</td>
                    @endif
                    <td width="3%">{{ $data->qa_status ?? '' }}</td>
                    <td width="3%">{{ $data->client_status ?? '' }}</td>
                    <td width="3%">{{ $data->user->reporting->name ?? '' }}</td>
                    <td width="3%">{{ $data->project->name ?? '' }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" class="text-center">No record found!</td>
            </tr>
        @endif

    </tbody>
    {{ $covid->links() }}

</table>

