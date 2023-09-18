<table class="table align-items-center table-flush" id="portion_table">
    <thead class="thead-light">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Agent</th>
            <th scope="col">record</th>
            <th scope="col">created-at</th>


        </tr>
    </thead>
    <tbody>
        @foreach($cru as $row)

            <tr>
                <td>{{$row->id}}</td>
                <td>{{$row->agent_name}}</td>
                <td>{{$row->record_id}} </td>
                <td>{{date('d-m-Y', strtotime($row->date))}}</td>

            </tr>
        @endforeach
    </tbody>
</table>
