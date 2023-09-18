<html>
    <head>
        <title>Export Mortgage</title>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
					<th>Record ID</th>
                    <th>pseudonym</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Zip</th>
                    <th>City</th>
                    <th>State</th>
					<th>QA Status</th>
					<th>QA Score</th>
					
					<th>Client Status</th>
                   <th>Project</th>
                    <th>ReportingTo</th>
                    <th>Agent Name</th>
                    <th>Agent HRMSID</th>
                    <th>Created At</th>
                    <th>QA Notes</th>
                </tr>
                
            </thead>
            <tbody>
                @php $cout=1; @endphp
                @foreach($saleMortgages as $row)
                    <tr>
                        <td>{{$cout++}}</td>
						<td>{{$row->record_id ?? ''}}</td>
                        <td>{{$row->user->pseudo_name ?? ''}}</td>
                        <td>{{$row->first_name ?? ''}}</td>
                        <td>{{$row->last_name ?? ''}}</td>
                        <td>{{$row->phone ?? ''}}</td>
                        <td>{{$row->email ?? ''}}</td>
                        <td>{{$row->address ?? ''}}</td>
                        <td>{{$row->zipcode ?? ''}}</td>
                        <td>{{$row->city ?? ''}}</td>
                        <td>{{$row->state ?? ''}}</td>
						<td>{{strtoupper($row->qa_status) ?? ''}}</td>
                        <td>{{$row->qa_score ?? ''}}</td>
                        
						<td>{{strtoupper($row->client_status) ?? ''}}</td>
                        <td>{{($row->project) ? $row->project->name:'' }}</td>
                        <td>{{ @$row->user->reporting_to_name}}</td>
                        <td>{{@$row->user->name ?? ''}}</td>
                        <td>{{@$row->user->HRMSID ?? ''}}</td>
                        <td>{{$row->created_at ?? ''}}</td>
                        <td>{{$row->qa_notes ?? ''}}</td>
                    </tr>
                @endforeach
            </tbody>            
        </table>
    </body>
</html>