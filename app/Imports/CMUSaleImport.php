<?php 

namespace App\Imports;

use App\Models\CMUSale;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CMUSaleImport implements WithMultipleSheets, WithHeadingRow
{ 
    public function sheets(): array
    {
        return [
            1 => new FirstSheetImport(), 
        ];
    }
     
}

// namespace App\Imports;

// use App\Models\CMUSale;
// use App\User;
// use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\ToCollection;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use Maatwebsite\Excel\Concerns\WithMultipleSheets;

// class CMUSaleImport implements ToCollection, WithHeadingRow
// {
//     public function collection(Collection $rows)
//     {
// 		// dd($rows);
//         $projects = \DB::table('projects')->where('client_id', 28)->get();
//         $array = array();
//         foreach($projects as $project){
//             $array[strtolower($project->abbrivation)]=$project->project_code;
//         }
        
//         foreach ($rows as $row) {
//             // dd($row);
//             foreach ($row as $key => $value) {
//                 if (array_key_exists($key,$array)) {
//                     try{
//                         CMUSale::create([
//                             "sale_date" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int)$row['date'])->format('Y-m-d')  ?? '',
//                             "hrms_id" => $row['hrmsid'],
//                             "name" => @$row['agent'],
//                             "project_code" => $array[$key],
//                             "count" => $value
//                         ]);
//                     }catch(\Exception $e){
//                         continue;
//                     }
                    
//                 }
                    
//             }
//         } 
//     }
//     public function getProjectName($row_name)
//     {
//         $project_name = '';
//         if ($row_name == 'live_conversation_outbound') {
//             $project_name = 'PRO0117';
//         } elseif ($row_name == 'dealership_discussion') {
//             $project_name = 'PRO0118';
//         } elseif ($row_name == 'why_calling') {
//             $project_name = 'PRO0119';
//         } elseif ($row_name == 'department') {
//             $project_name = 'PRO0120';
//         } elseif ($row_name == 'reason_for_outbound_call') {
//             $project_name = 'PRO0121';
//         } elseif ($row_name == 'handled_by_voice_recognition') {
//             $project_name = 'PRO0122';
//         }
//         return $project_name;
//     }
// }
