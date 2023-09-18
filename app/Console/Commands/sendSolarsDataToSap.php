<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Models\RecordDetail; use DB;
use App\Models\Campaign;
use App\Models\Client;
use App\Models\Project;
use App\Models\Role; 
use App\Models\SaleRecord;
use App\Models\SaleMortgage;
use App\Models\HomeWarranty;
use Illuminate\Support\Facades\Http;
use Orchestra\Parser\Xml\Facade as XmlParser;
use App\Jobs\SendSolarData;
use Illuminate\Foundation\Bus\DispatchesJobs;
class sendSolarsDataToSap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendSolarsDataToSap:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		set_time_limit(0);$test =array(); $response=array();
        $clients = DB::table('sale_records')->groupBy('client_code')->whereDate('created_at',">=","2023-02-01")->pluck('client_code'); 
        foreach($clients as $row){
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
                ->where('client_code',$row)          
                ->where('sap_id',0)  
                ->whereDate('created_at',">=","2023-02-01")    
                ->havingRaw('Quantity > 0') 
                ->groupBy('user_id','created_at','project_code')->get();      
            $userIds=array();    
            if($sales->isEmpty())
                continue; 
            $arrayData=array(); 
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
                $arrayData[date("Y-m-d",strtotime($sale->DocDate))][] = $rw; 
                $date['SalesEmployee'] = $sale->SalesEmployee;
                $date['date'] = $sale->DocDate;
                $userIds[date("Y-m-d",strtotime($sale->DocDate))][] =$date;  
            } 
                         
            foreach($arrayData as $key => $value){
                $postSapData=array();                    
                $postSapData['APIKey']="$%fsdfkbAusfiewrg93485#&^";
                $postSapData['DocDate']=date("Y-m-d",strtotime($key));
                $postSapData['CardCode']=$sale->CardCode;              
                $postSapData['DocumentLines']=$value;
                // return $postSapData;
                $data['CardCode']=$row; 
                $data['DocumentLines']=$postSapData; 
                $url="http://tsc.isap.pk:9001/api/Revenue/Sales";   
                $ch = curl_init();
                curl_setopt ($ch, CURLOPT_URL, $url);
                curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt ($ch, CURLOPT_POST, 1);
                curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
                curl_setopt ($ch, CURLOPT_POSTFIELDS,json_encode($postSapData));
                curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                $result = curl_exec ($ch);
                curl_close($ch);
                $result = json_decode ($result); 
                if(@$result->status == "Error"){
                    if(@$result->statusCode == 100 || @$result->statusCode == 101 || @$result->statusCode == 102 || @$result->statusCode == 103){
                        if(@$result->data){
                            foreach(@$result->data as $item){
                                \DB::table('missing_items')->insert([
                                    'statusCode' =>@$result->statusCode,
                                    'missing_code' =>@$item,
                                    'project'=> "Solar"
                                ]);
                            }
                        }
                    }
                     DB::table('sap_logs')->insert(['sap_response'=>json_encode(@$result), 'sap_post_data'=>json_encode($postSapData),'status'=>3,'type'=>"Solar" ]);
                }elseif(@$result->status == "Success"){
                    DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>1,'type'=>"Solar" ]);
                }else{
                     DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>2,'type'=>"Solar" ]);
                    continue;
                }
                foreach($value as $rw){   
                    $ids =  DB::table("sale_records")->where('user_id',$rw['SalesEmployee'])
                            ->where('sap_id',0)->where('client_status',"billable")->where('project_code',$rw['ItemCode'])
                            ->whereDate("created_at",$key)->pluck('id');

                    DB::table("sale_records")->whereIn('id',$ids)->update([
                        'sap_id'=>@$result->sapReference ? @$result->sapReference : 0,
                        'sap_response'=>json_encode($result),
                        'sap_post_data'=>json_encode($postSapData),
                    ]);
                } 
            } 
        }  
        return response()->json(['status'=>200,'message'=>"success"]);
    }
}
