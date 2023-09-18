<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Client; use DB;
class SendSolarData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        set_time_limit(0);
        $row = Client::where('campaign_id',2)->first(); $arrayData=array();
        $sales = DB::table('sale_records')
                ->select('client_code as CardCode','project_code as ItemCode')
                ->selectRaw("
                            Count(CASE WHEN sale_records.client_status = 'billable' THEN 1 ELSE NULL END) AS Quantity,
                            Count(CASE WHEN sale_records.qa_status = 'billable' THEN 1 ELSE NULL END) AS QABillable,
                            Count(CASE WHEN sale_records.qa_status = 'non-billable' THEN 1 ELSE NULL END) AS QANonBillable,
                            Count(CASE WHEN sale_records.qa_status = 'pending' THEN 1 ELSE NULL END) AS QAPending,
                            Count(CASE WHEN sale_records.client_status = 'pending' THEN 1 ELSE NULL END) AS ClientPending,
                            user_id as SalesEmployee, 
                            created_at as DocDate
                        ")
                ->where('client_code',$row->client_code)
                ->whereDate('created_at',"=","2022-07-27") 
                ->whereNull('sap_id')
                ->groupBy('user_id','created_at')->get();      
        $userIds=array();      
        foreach($sales as $sale){
            if($sale->Quantity<=0){
                continue;
            }   
            $rw['ItemCode']=(string)$sale->ItemCode;
            $rw['Quantity']= $sale->Quantity; 
            $rw['QABillable']=(string)$sale->QABillable;
            $rw['QANonBillable']=(string)$sale->QANonBillable; 
            $rw['QAPending']=(string)$sale->QAPending;
            $rw['ClientPending']=(string)$sale->ClientPending; 
            $rw['SalesEmployee']=(string)$sale->SalesEmployee;
            $rw['QAScore']="0"; 
            $rw['AgentCallsCount']="0"; 
            $arrayData[$sale->DocDate][] = $rw; 

            $date['SalesEmployee'] = $sale->SalesEmployee;
            $date['date'] = $sale->DocDate;
            $userIds[$sale->DocDate][] =$date;  
        } 
        $arrayData1=array();
         
        foreach($arrayData as $key => $value){                    
            $arrayData1['APIKey']="$%fsdfkbAusfiewrg93485#&^";
            $arrayData1['DocDate']=date("Y-m-d",strtotime($key));
            $arrayData1['CardCode']=$sale->CardCode;              
            $arrayData1['DocumentLines']=$value; 
             

            $url="http://tsc.isap.pk:9001/api/Revenue";   
            $ch = curl_init();
            curl_setopt ($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt ($ch, CURLOPT_POST, 1);
            curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt ($ch, CURLOPT_POSTFIELDS,json_encode($arrayData1));
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $result = curl_exec ($ch);
            curl_close($ch);
            $result = json_decode ($result);
            if($result->status == "Success"){
                foreach($value as $rw){  
                    $ids =  DB::table("sale_records")->where('user_id',$rw['SalesEmployee'])
                            ->whereNull('sap_id')->where('client_status',"billable")
                            ->whereDate("created_at",date("Y-m-d",strtotime($key)))->pluck('id');

                    DB::table("sale_records")->whereIn('id',$ids)->update([
                        'sap_id'=>$result->sapReference,
                        'sap_response'=>json_encode($result),
                        'post_data'=>json_encode($arrayData1),
                    ]);
                }
                
            }  
        }
          
    }
}
