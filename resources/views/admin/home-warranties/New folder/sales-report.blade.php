<table class="table align-items-center table-flush">
    <thead class="thead-light">
        <tr>
            <th scope="col">HRMS ID</th>
            <th scope="col">Agent Name</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Phone</th>
            <th scope="col">State</th>
            <th scope="col">Client</th>
            <th scope="col">Created Date</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @if (count($home_warranties) > 0)
            @foreach ($home_warranties as $home_warranty)
                <tr>
                    <td>{{ $home_warranty->hrms_id ?? '' }}</td>
                    <td>{{ $home_warranty->agent_detail->name ?? '' }}</td>
                    <td>{{ $home_warranty->first_name ?? '' }}</td>
                    <td>{{ $home_warranty->last_name ?? '' }}</td>
                    <td>{{ $home_warranty->phone ?? '' }}</td>
                    <td>{{ $home_warranty->state ?? '' }}</td>
                    <td>{{ $home_warranty->client ?? '' }}</td>
                    <td>{{ $home_warranty->created_at ?? '' }}</td>
                    <td>{{ $home_warranty->status ?? '' }}</td>
                    <td>
                        <a href="{{ route('home-warranties.show', $home_warranty) }}"
                            class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('home-warranties.edit', $home_warranty) }}"
                            class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        @if (in_array(Auth::user()->roles[0]->name, ['Super Admin']))
                            <a href="{{ route('home-warranties.delete', $home_warranty) }}"
                                class="btn btn-warning btn-sm"><i class="fas fa-trash"></i></a>
                        @endif
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
