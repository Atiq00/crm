<?php

namespace App\Imports;
 
use App\Models\EddySale;
use App\Models\EddyUser;use DB; use Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Http\Request;
class UpdateBillableStatus implements ToCollection, WithHeadingRow
{

   

    public function collection(Collection $rows)
    {   
		$date = date('Y-m-d', strtotime("-90 days"));
		foreach($rows as $row){  
			try{  

				DB::table(request('table'))->where('phone',$row)
					->latest()->limit(1)
					->where('project_code',request('project_id'))
					->update(['client_status'=>'billable']) ;
					
				$result = DB::table(request('table'))->where('phone',$row)->latest()->first(); 
				if($result) {
					DB::table("update_billable_logs")->insert([
						'sale_id' =>@$result->id,
						'type' =>request('table'),
						'old_status' =>$result->client_status,
						'new_status' =>"billable",
						'HRMSID' =>Auth::user()->HRMSID,
					]);
				}
			}catch (\Exception $e) {
				continue;
			}

			
		}	
    }

}
