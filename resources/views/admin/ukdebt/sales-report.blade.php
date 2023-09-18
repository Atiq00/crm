<table class="table align-items-center table-flush" id="basic-datatable">
    <thead class="thead-light">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Agent Name</th>
            <th scope="col">Agent HRMSID</th>
            <th scope="col">FirstName</th>
            <th scope="col">LastName</th>
            <th scope="col">Phone</th>
            <th scope="col">Email</th>
            <th scope="col">Client</th>
            <th scope="col">Created at</th>


        </tr>
    </thead>
    <tbody>
        @foreach($uk as $row)

            <tr>
                <td>{{$row->id}}</td>
                <td>{{($row->user) ? $row->user->name:'' }}</td>
                <td>{{($row->user) ? $row->user->HRMSID:'' }}</td>
                <td>{{$row->first_name}} </td>
                <td>{{$row->last_name}}</td>
                <td>{{$row->phone}}</td>
                <td>{{$row->email}}</td>
                <td>{{$row->client}}</td>
                <td>{{$row->created_at}}</td>

            </tr>
        @endforeach
    </tbody>
</table>
