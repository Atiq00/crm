<table class="table align-items-center table-flush" id="portion_table">
    <thead class="thead-light">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Agent</th>
            <th scope="col">Count</th>


        </tr>
    </thead>
    <tbody>
        @foreach($cruc as $row)

            <tr>
                <td>{{$row->id}}</td>.
                <td>{{$row->agent_name}}</td>
                <td>{{$row->count}}</td>

            </tr>
        @endforeach
    </tbody>
</table>
