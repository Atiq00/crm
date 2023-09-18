<?php

namespace App\Imports;

use App\Models\EddySale;
use App\Models\EddyUser;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Http\Request;
class EddyImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $rows)
    {
        // dd($rows);exit;

        foreach ($rows as $row) {
            // dd(date('Y-m-d', strtotime($row['date'])));
            $agent_type = EddyUser::where('agent_name', $row['agent_id'])->first();
            $count = EddySale::whereDate('sale_date', date('Y-m-d', strtotime($row['date'])))->where('agent_id', $row["agent_id"])->first();
            if ($count) { 
                continue;
            }  
            EddySale::create([
                "sale_date" => date('Y-m-d', strtotime($row['date'])) ?? '',
                "hrms_id" => $row["hrms_id"] ?? 0,
                "agent_id" => trim($row["agent_id"]) ?? '-',
                "billable_hours" => $row["billable_hours"] ?? 0,
                "call_hours" => $row["call_hours"] ?? 0,
                "calls_per_billable_hours" => $row["calls_per_billable_hours"] ?? 0,
                "total_calls" => $row["total_calls"] ?? 0,
                "total_connects" => $row["total_connects"] ?? 0,
                "connects" => $row["connects"] ?? 0,
                "connect_percentage" => $row["connect_percentage"] ?? 0,
                "deassign_percentage" => $row["deassign_percentage"] ?? 0,
                "aht" => $row["aht"] ?? 0,
                "edu_transfers" => $row["edu_transfers"] ?? 0,
                "edu_tph" => $row["edu_tph"] ?? 0,
                "edu_transfer_rate" => $row["edu_transfer_rate"] ?? 0,
                "edu_conversions" => $row["edu_conversions"] ?? 0,
                "edu_cph" => $row["edu_cph"] ?? 0,
                "edu_conv_percentage_of_transfers" => $row["edu_conv_percentage_of_transfers"] ?? 0,
                "edu_conv_percentage_of_connects" => $row["edu_conv_percentage_of_connects"] ?? 0,
                "edu_conv_percentage_of_total_calls" => $row["edu_conv_percentage_of_total_calls"] ?? 0,
                "transfers" => $row["transfers"] ?? 0,
                "transfers_percentage" => $row["transfers_percentage"] ?? 0,
                "people" => $row["people"] ?? 0,
                "forms" => $row["forms"] ?? 0,
                "lts" => $row["lts"] ?? 0,
                "conv_percentage" => $row["conv_percentage"] ?? 0,
                "lt_percentage" => $row["lt_percentage"] ?? 0,
                "lpp" => $row["lpp"] ?? 0,
                "lph" => $row["lph"] ?? 0,
                "wlph" => $row["wlph"] ?? 0,
                "pph" => $row["pph"] ?? 0,
                "wlpc" => $row["wlpc"] ?? 0,
                "type" => $agent_type->type ?? '',
				"project_code" => $agent_type->project_code ?? ''
            ]);
        }
    }
}
