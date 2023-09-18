<?php

namespace App\Imports;

use App\Models\CallAnalyticSale;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CallAnalyticImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $keys = array_keys($row->toArray());
            if (($keys[0] == 'date') && ($keys[1] == 'hrms_id') && ($keys[2] == 'name') && ($keys[3] == 'count')) {
                CallAnalyticSale::create([
					"sale_date" => date('Y-m-d', strtotime($row['date'])) ?? '',
                    "hrms_id" => $row["hrms_id"] ?? '-',
					"name" => $row["name"] ?? '-',
                    "project_code" => "PRO0123" ?? '-',
                    "count" => $row["count"] ?? '-',
                ]);
            }
        }
    }
}
