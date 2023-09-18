<table class="table align-items-center table-flush" id="myTable">
    <thead class="thead-light">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">PSEUDONYM</th>
            <th scope="col">Total Sales</th>
            <th scope="col">Booked</th>
            <th scope="col">DNQ</th>
            <th scope="col">Pending</th>
            <th scopr="col">Projects</th>
            <th scopr="col">Hire-Date</th>
            <th scopr="col">Campaign-Hire-date</th>
            <th scopr="col">Agent Tenure</th>
            <th scopr="col">Created-At</th>
            <th scopr="col">Status</th>
            <th scopr="col">Action</th>




        </tr>
    </thead>
    <tbody>
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
                <td>

                        <a class="btn btn-primary" href="{{ route('agent.edit',$row->userID) }}">Edit</a>

                </td>

            </tr>
        @endforeach



    </tbody>


</table>
 

@push('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script>

<script>  

    $(document).ready(function () {
        $('#myTable').DataTable({
            "dom": 'Bfrtip', 
            "paging": true,
            "pageLength": 100,
            "buttons": [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    });
 
</script>
<form action="#" method="post" id="FORM_DELETE">
    @csrf
    @method('DELETE')
</form>
@endpush
