<table class="table align-items-center table-flush" id="basic-datatable">
    <thead class="thead-light">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Agent-Name</th>
            <th scope="col">Live-Request</th>
            <th scope="col">Test-Request</th>
            <th scope="col">Total-Live+Test-Request</th>
            <th scope="col">Ach-Agent-Wise</th>
            <th scope="col">AVG-Handling-Time</th>
            <th scope="col">Quotation-ID</th>
            <th scope="col">Created at</th>


        </tr>
    </thead>


    <tbody>
        @foreach($amg1 as $row)

            <tr>
                <td>{{$row->id}}</td>
                <td>{{$row->AgentName}}</td>
                <td>{{$row->l_r_count}} </td>
                <td>{{$row->t_r_count}}</td>
                <td>{{$row->t_l_r_count}}</td>
                <td>{{ round($row->avg, 2) }}%</td>
                <td>{{$row->a_t_r}}</td>
                <td>{{$row->q_t}}</td>
                <td>{{$row->date }}</td>

            </tr>
        @endforeach
    </tbody>
</table>
