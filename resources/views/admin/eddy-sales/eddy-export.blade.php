<table class="table align-items-center table-flush">
    <thead>
        <tr>
            <th>Sale Date</th>
            <th>HRMS ID</th>
            <th>Agent ID</th>
            <th>Billable Hours</th>
            <th>Call Hours</th>
            <th>Calls Per Billable Hours
            </th>
            <th>Total Calls
            </th>
            <th>Total Connects
            </th>
            <th>Connects
            </th>
            <th>Connect Percentage
            </th>
            <th>Deassign Percentage
            </th>
            <th>AHT
            </th>
            <th>Edu Transfers
            </th>
            <th>Edu TPH
            </th>
            <th>Edu Transfer Rate
            </th>
            <th>Edu Conversions
            </th>
            <th>Edu CPH
            </th>
            <th>Edu Conv Percentage of Transfers
            </th>
            <th>Edu Conv Percentage of Connects
            </th>
            <th>Edu Conv Percentage of total calls
            </th>
            <th>Transfers
            </th>
            <th>Transfers Percentage
            </th>
            <th>People
            </th>
            <th>Forms
            </th>
            <th>LTs
            </th>
            <th>Conv Percentage
            </th>
            <th>LT Percentage
            </th>
            <th>LPP
            </th>
            <th>LPH
            </th>
            <th>WLPH
            </th>
            <th>PPH
            </th>
            <th>WLPC
            </th>
            <th>Type</th>
            <th>Created at</th>

        </tr>
    </thead>
    <tbody>
        @if (!$eddy->isEmpty())
            <?php $count = 1; ?>
            @foreach ($eddy as $row)
                <tr>
                    <td>{{ date('m-d-Y', strtotime(@$row->sale_date)) }}</td>
                    <td>{{ @$row->hrms_id ?? '' }}</td>
                    <td>{{ @$row->agent_id ?? 0 }} </td>
                    <td>{{ @$row->billable_hours ?? '' }}</td>
                    <td>{{ @$row->call_hours ?? '' }}</td>
                    <td>{{ @$row->calls_per_billable_hours ?? '' }}</td>
                    <td>{{ @$row->total_calls ?? '' }}</td>
                    <td>{{ @$row->total_connects ?? '' }}</td>
                    <td>{{ @$row->connects ?? '' }}</td>
                    <td>{{ @$row->connect_percentage ?? '' }}</td>
                    <td>{{ @$row->deassign_percentage ?? '' }}</td>
                    <td>{{ @$row->aht ?? '' }}</td>
                    <td>{{ @$row->edu_transfers ?? '' }}</td>
                    <td>{{ @$row->edu_tph ?? '' }}</td>
                    <td>{{ @$row->edu_transfer_rate ?? '' }}</td>
                    <td>{{ @$row->edu_conversions ?? '' }}</td>
                    <td>{{ @$row->edu_cph ?? '' }}</td>
                    <td>{{ @$row->edu_conv_percentage_of_transfers ?? '' }}</td>
                    <td>{{ @$row->edu_conv_percentage_of_connects ?? '' }}</td>
                    <td>{{ @$row->edu_conv_percentage_of_total_calls ?? '' }}</td>
                    <td>{{ @$row->transfers ?? '' }}</td>
                    <td>{{ @$row->transfers_percentage ?? '' }}</td>
                    <td>{{ @$row->people ?? '' }}</td>
                    <td>{{ @$row->forms ?? '' }}</td>
                    <td>{{ @$row->lts ?? '' }}</td>
                    <td>{{ @$row->conv_percentage ?? '' }}</td>
                    <td>{{ @$row->lt_percentage ?? '' }}</td>
                    <td>{{ @$row->lpp ?? '' }}</td>
                    <td>{{ @$row->lph ?? '' }}</td>
                    <td>{{ @$row->wlph ?? '' }}</td>
                    <td>{{ @$row->pph ?? '' }}</td>
                    <td>{{ @$row->wlpc ?? '' }}</td>
                    <td>{{ @$row->type }}</td>
                    <td>{{ date('m-d-Y', strtotime(@$row->created_at)) }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
