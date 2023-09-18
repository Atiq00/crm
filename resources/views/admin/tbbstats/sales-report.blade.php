<table class="table align-items-center table-flush" id="basic-datatable">
    <thead class="thead-light">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Agent-Name</th>
            <th scope="col">Package-Request</th>
            <th scope="col">Cruise-Request</th>
            <th scope="col">Chat-Request</th>
            <th scope="col">Total-Package+Cruise+Chat-Request</th>
            <th scope="col">Ach-Agent-Wise</th>
            <th scope="col">Quotation-ID</th>
            <th scope="col">AVG-Handling-Time</th>
            <th scope="col">Created at</th>


        </tr>
    </thead>


    <tbody>
        @foreach($tbb1 as $row)

            <tr>
                <td>{{$row->id}}</td>
                <td>{{$row->AgentName}}</td>
                <td>{{$row->p_r_count}} </td>
                <td>{{$row->cr_r_count}}</td>
                <td>{{$row->c_r_count}}</td>
                <td>{{$row->t_p_r_count}}</td>
                <td>{{round($row->avg,2)}}%</td>
                <td>{{round($row->q_t)}}</td>
                <td>{{$row->a_t_r}}</td>
                <td>{{$row->date }}</td>

            </tr>
        @endforeach
    </tbody>
</table>
