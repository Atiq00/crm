<table class="table align-items-center table-flush">
    <thead class="thead-light">
        <tr>
           <th scope="col">No</th>

            <th scope="col">Created Date</th>
            <th scope="col">HRMS ID</th>
			 <th scope="col">Pseudonym</th> 
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Phone</th>
            @if(auth()->user()->hasRole('Super Admin'))
            <th scope="col">Phone</th>
            @endif
            <th scope="col">State</th>
            <th scope="col">Closers</th>
            <th scope="col">Other Closers</th>
            <th scope="col">Square Feet</th>
            <th scope="col">Buffer</th>
            <th scope="col">ReportingTo</th> 


        </tr>
    </thead>
    <tbody>
        @if (count($home_warranty_external) > 0)
            @foreach ($home_warranty_external as $home_warranty)
                <tr>
                    <!-- {{ ($home_warranty->reporting ) }} -->
                    <td>{{$loop->iteration}}</td>
                    <td width="3%">{{ $home_warranty->created_at ?? '' }}</td>
                    <td width="3%">{{ $home_warranty->hrms_id ?? '' }}</td>
					<td width="3%">{{ $home_warranty->agent_detail->pseudo_name ?? '' }}-{{ $home_warranty->agent_detail->name ?? '' }}</td> 
                    <td width="3%">{{ $home_warranty->first_name ?? '' }}</td>
                    <td width="3%">{{ $home_warranty->last_name ?? '' }}</td>
                    <td width="3%">{{substr($home_warranty->phone, 0, 3) }}***{{ substr($home_warranty->phone,-4) }}</td>
                    @if(auth()->user()->hasRole('Super Admin'))
                    <td width="3%">{{$home_warranty->phone }}</td>
                    @endif
                    <td width="3%">{{ $home_warranty->state ?? '' }}</td>
                    <td width="3%">{{ $home_warranty->closers ?? '' }}</td>
                    <td width="3%">{{ $home_warranty->other_closers ?? '' }}</td>
                    <td width="3%">{{ $home_warranty->square_feet ?? '' }}</td>
                    <td width="3%">{{ $home_warranty->buffer ?? '' }}</td>
                    <td width="3%">{{ $home_warranty->user->reporting->name ?? '' }}</td> 
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" class="text-center">No record found!</td>
            </tr>
        @endif

    </tbody>

</table>
