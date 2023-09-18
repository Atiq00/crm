<html>
    <head>
        <title>Export Mortgage</title>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>pseudonym</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Zip</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Client</th>
                    <th>Project</th>
                    <th>Agent Name</th>
                    <th>Agent HRMSID</th>
					<th>Reporting to</th>
                    <th>Client status</th>									
					<th>QA status</th>
					<th>QA Score</th>
                    <th>Client</th>
                    <th>Appt Date</th>
					<th>Project</th>
                    <th>Created At</th>
                    <th>QA Notes</th>
                </tr>
                
            </thead>
            <tbody>
                @php $cout=1; @endphp
                @foreach($saleSolars as $row)
                    <tr>
                        <td>{{$cout++}}</td>
                        <td>{{$row->first_name ?? ''  }}</td>
                        <td>{{$row->last_name ?? '' }}</td>
                        <td>{{$row->user->pseudo_name ?? ''}}</td>
                        <td>{{$row->phone ?? '' }}-{{@$row->posting->leadid}}</td>
                        <td>{{$row->email ?? '' }}</td>
                        <td>{{$row->address ?? '' }}</td>
                        <td>{{$row->zipcode ?? '' }}</td>
                        <td>{{$row->city ?? '' }}</td>
                        <td>{{$row->state ?? '' }}</td>
                        <td>{{@$row->client->name ?? '' }} </td>
                        <td>{{@$row->project->name ?? '' }} </td>
                        <td>{{@$row->user->name ?? '' }}</td>
                        <td>{{@$row->user->HRMSID ?? '' }}</td>
						<td>{{@$row->user->reporting->name ?? '' }}</td>
                        <td>{{@$row->client_status}}</td>
                        <td>{{$row->qa_status ?? ''}}</td>
						<td>{{@$row->qa_score}}</td>
                        <td>{{(@$row->client) ? @$row->client->name:'' }} </td>
                        <td>{{@$row->app_date_time}}</td>
						<td> {{(@$row->project) ? @$row->project->name:'' }} </td>
                        <td>{{@$row->created_at ?? '' }}</td>
                        <td>{{@$row->qa_notes ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>            
        </table>
    </body>
</html>