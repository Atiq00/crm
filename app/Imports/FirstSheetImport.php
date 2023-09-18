<?php
namespace App\Imports;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use App\Models\CMUSale;
class FirstSheetImport implements ToArray, WithCalculatedFormulas
{
    public function array(array $rows)
    {         
        $projects = \DB::table('projects')->where('client_id', 28)->get();
        $projectCodes = array();
        foreach($projects as $project){
            $projectCodes[$project->abbrivation]=$project->project_code;
        }
        $heading = ($rows[2]);          
        foreach ($rows as $row) {
            $data = array();
            if(@$row[0] == null || @$row[0] == 'null'  || @$row[0] == '' || @$row[0] == 0 || @$row[0] == '0' || @$row[0] == "Grand Total" || @$row[0] == "Row Labels") 
                continue; 
            foreach($row as $key => $rw){ 
                $key = str_replace("Sum of ","",$heading[$key]);
                if($key == "Row Labels"){
                    $key = "hrms_id";
                }
                $data[$key] = $rw;
            } 
            // dd($data);           
            foreach ($data as $key => $value) {                
                if (array_key_exists($key,$projectCodes)) {
                    try{
                        CMUSale::create([
                            "sale_date" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int)@$data['Date'])->format('Y-m-d')  ?? '',
                            "hrms_id" => $data['hrms_id'],
                            "name" => @$data['agent'],
                            "project_code" => $projectCodes[$key],
                            "count" => $value
                        ]);
                    }catch(\Exception $e){
                        continue;
                    }                    
                }                    
            }             
        }  
    }
}
?>