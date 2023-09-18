<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Client; use DB;
class CruSale extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CruSale:cron';

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
        set_time_limit(0);$test =array(); 
        $arrayData=array();
        $sales = DB::table('cru_sales')->join('cru_users','cru_users.cru_id','cru_sales.agent_name')->selectRaw("
            agent_name,
            cru_users.hrms_id,
            Count(cru_sales.id) AS Quantity ,cru_sales.created_at              
        ")
        ->whereDate('cru_sales.created_at',">=","2023-02-01")  
        ->whereDate('cru_sales.created_at',"<=","2023-02-28")   
        ->where('sap_id',0)->groupBy('created_at','agent_name')->get()->groupby('created_at'); 
        foreach($sales as $key => $value){  
             
            $postSapData=array();  $ids =[];
            $postSapData['APIKey']="$%fsdfkbAusfiewrg93485#&^";
            $postSapData['DocDate']=date("Y-m-d",strtotime($key));
            $postSapData['CardCode']="CUS-100061"; 
            $singlePacket=array();
            foreach($value as $rw){ 
                if($rw->Quantity<=0){
                    continue;
                }  
                $row['ItemCode']="PRO0142";
                $row['Quantity']= (int)$rw->Quantity; 
                $row['QABillable']="0";
                $row['QANonBillable']="0"; 
                $row['QAPending']="0";
                $row['ClientPending']="0"; 
                $row['SalesEmployee']=(string)$rw->hrms_id;
                $row['QAScore']="0"; 
                $row['AgentCallsCount']="0"; 
                $singlePacket[]=$row;
                $ids[]=$rw->agent_name;
            }         
            $postSapData['DocumentLines']=$singlePacket; 
            // return ($postSapData); 
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
                                'project' =>"CRU"
                            ]);
                        }
                    }
                }
                DB::table('sap_logs')->insert(['sap_response'=>json_encode(@$result), 'sap_post_data'=>json_encode($postSapData),'status'=>3,'type'=>"CRU" ]);
            }
            // elseif(@$result->status == "Success"){
            //     DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>1,'type'=>"CRU" ]);
            // }else{
            //     DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>2,'type'=>"CRU" ]);
            //     continue;
            // }
            DB::table("cru_sales")->whereIn('agent_name',$ids)->whereDate('created_at',$key)->update([
                'sap_id'=>(@$result->sapReference) ? @$result->sapReference:0,
                'sap_response'=>json_encode($result),
                'post_data'=>json_encode($postSapData),
            ]);
            
        }  
        return response()->json(['status'=>200,'message'=>"success"]);
    }
}
