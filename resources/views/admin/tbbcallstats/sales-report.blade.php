<table class="table align-items-center table-flush" id="basic-datatable">
    <thead class="thead-light">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Agent-Name</th>
            <th scope="col">No of Calls</th>
            <th scope="col">Quotations from calls</th>
            <th scope="col">Bookings</th>
            <th scope="col">No of Calls+Quotations from calls+Bookings</th>
            <th scope="col">Ach-Agent-Wise</th>
            <th scope="col">AVG-Handling-Time</th>
            <th scope="col">Created at</th>


        </tr>
    </thead>


    <tbody>
        @foreach($tbbcall1 as $row)

            <tr>
                <td>{{$row->id}}</td>
                <td>{{$row->AgentName}}</td>
                <td>{{$row->n_r_count}} </td>
                <td>{{$row->quo_r_count}}</td>
                <td>{{$row->b_r_count}}</td>
                <td>{{$row->t_p_r_count}}</td>
                <td>{{round($row->avg,2)}}%</td>
                <td>{{$row->a_t_r}}</td>
                <td>{{$row->date }}</td>

            </tr>
        @endforeach
    </tbody>
</table>
