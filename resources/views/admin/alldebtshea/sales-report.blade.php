<table class="table align-items-center table-flush">
    <thead class="thead-light">
    <tr>
        <th scope="col" width="3%">Serial ID</th> 
        <th scope="col" width="3%">Created At</th>
        <th scope="col" width="3%">First Name</th>
        <th scope="col" width="3%">Last Name</th>
        <th scope="col" width="3%">Phone</th>    
        <th scope="col" width="3%">State</th> 
        <th scope="col" width="3%">ZipCode</th> 
        <th scope="col" width="3%">Agent Name</th>  
        <th scope="col" width="3%">Agent HRMSID</th>
        <th scope="col" width="3%">Reporting To</th>
        <th scope="col" width="3%">Client status</th>									
        <th scope="col" width="3%">QA status</th>  
        <th scope="col" width="3%">Action</th>
</tr>
    </thead>
    <tbody>
        @if (count($alldebshea_external) > 0)
            @foreach($alldebshea_external as $key=> $row)
                <tr>
                    <td>{{ $alldebshea_external->firstItem()+$key }}</td> 
                    <td>{{$row->created_at}}</td>
                    <td>{{$row->first_name}} </td> 
                    <td>{{$row->last_name}}</td>  
                    <td>{{substr($row->phone, 0, 3) }}***{{ substr($row->phone,-4) }}</td>  
                    <td>{{$row->state}}</td> 
                    <td>{{$row->zipcode}}</td>                     
                    <td>{{($row->user) ? $row->user->name:'' }}-{{$row->user->pseudo_name ?? ''}}</td>  
                                    
                    <td>{{($row->user) ? $row->user->HRMSID:'' }}</td>
                    <td>{{ $row->user->reporting->name ?? '' }}</td>
                    <td>{{$row->client_status}}</td>
                    <td>{{$row->qa_status}}</td>   
                    <td>  
                        <a href="{{route('solars.show',[$row->id])}}" class="btn btn-success btn-sm">View</a>     
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" class="text-center">No record found!</td>
            </tr>
        @endif

    </tbody>

</table>
