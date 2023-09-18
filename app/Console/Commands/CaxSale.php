<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Client; use DB;
class CaxSale extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CaxSale:cron';

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
        $sales = DB::table('call_analytic_sales') 
                ->groupby('created_at','hrms_id')
                ->whereDate('created_at',">=","2023-01-01")  
                ->where('sap_id',0)->where('count',">",0)->get()->groupby('created_at');

        foreach($sales as $key => $value){  
        
            $postSapData=array();  $ids =[];
            $postSapData['APIKey']="$%fsdfkbAusfiewrg93485#&^";
            $postSapData['DocDate']=date("Y-m-d",strtotime($key));
            $postSapData['CardCode']="CUS-100040"; 
            $singlePacket=array();
            foreach($value as $rw){ 
                if($rw->count<=0){
                    continue;
                }  
                $row['ItemCode']="PRO0123";
                $row['Quantity']= (int)$rw->count; 
                $row['QABillable']="0";
                $row['QANonBillable']="0"; 
                $row['QAPending']="0";
                $row['ClientPending']="0"; 
                $row['SalesEmployee']=(string)$rw->hrms_id;
                $row['QAScore']="0"; 
                $row['AgentCallsCount']="0"; 
                $singlePacket[]=$row;
                $ids[]=$rw->id;
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
                                'project' => "CAX"
                            ]);
                        }
                    }
                }
                DB::table('sap_logs')->insert(['sap_response'=>json_encode(@$result), 'sap_post_data'=>json_encode($postSapData),'status'=>3,'type'=>"CAX" ]);
            }elseif(@$result->status == "Success"){
                DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>1,'type'=>"CAX" ]);
            }else{
                DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>2,'type'=>"CAX" ]);
                continue;
            }
            DB::table("call_analytic_sales")->whereIn('id',$ids)->where('created_at',$key)->update([
                'sap_id'=>(@$result->sapReference) ? @$result->sapReference:0,
                'sap_response'=>json_encode($result),
                'post_data'=>json_encode($postSapData),
            ]);
            
        }  
        return response()->json(['status'=>200,'message'=>"success"]); 
    }
}


