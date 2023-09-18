<html>
    <head>
        <title>Export</title>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>PSEUDONYM</th>
                    <th>Total Sales</th>
                    <th>Booked</th>
                    <th>DNQ</th>
                    <th>Pending</th>
                    <th>Projects</th>
                    <th>Hire-Date</th>
                    <th>Campaign-Hire-date</th>
                    <th>Agent Tenure</th>
                    <th>Created-At</th>
                    <th>Status</th>
                </tr>
                
            </thead>
            <tbody>
                @php $cout=1; @endphp
                @foreach($solaragent as $row)
                    <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{@$row->Pseudonym ?? ''}} </td>
                <td>{{@$row->SaleCount ?? ''}}</td>
                <td>{{@$row->booked ?? ''}}</td>
                <td>{{@$row->NotBill ?? ''}}</td>
                <td>{{@$row->Pending ?? ''}}</td>
                <td>{{@$row->ProjectName ?? ''}}</td>
                <td>{{@$row->hiredate ?? ''}}</td>
                <td>{{@$row->Campaign_Hire_Date ?? ''}}</td>
                <td>{{@$row->AgentTenure ?? ''}}</td>
                <td>{{@$row->created_at ?? ''}}</td>
                <td>{{@$row->campstatus ?? ''}}</td>
                    </tr>
                @endforeach
            </tbody>            
        </table>
    </body>
</html>