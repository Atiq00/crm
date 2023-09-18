<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Client; use DB;
class FixedPriceSale extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FixedPriceSale:cron';

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
        $sales = \DB::table('seat_based_project_users')->select('HRMSID as SalesEmployee','client_code','project_code')->get();    
        $sales = $sales->groupBy('client_code');          
        foreach($sales as $key => $value){ 
            $postSapData=array();  
            $postSapData['APIKey']="$%fsdfkbAusfiewrg93485#&^";
            $postSapData['DocDate']=date("Y-m-d");
            $postSapData['CardCode']="$key"; $singlePacket=array();
            foreach($value as $rw){
                $row['ItemCode']=$rw->project_code;
                $row['Quantity']= 1; 
                $row['QABillable']="0";
                $row['QANonBillable']="0"; 
                $row['QAPending']="0";
                $row['ClientPending']="0"; 
                $row['SalesEmployee']=(string)$rw->SalesEmployee;
                $row['QAScore']="0"; 
                $row['AgentCallsCount']="0"; 
                $singlePacket[]=$row;
            }         
            $postSapData['DocumentLines']=$singlePacket; //return $postSapData;
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
                                'project' => "FixedPrice"
                            ]);
                        }
                    }
                }
                DB::table('sap_logs')->insert(['sap_response'=>json_encode(@$result), 'sap_post_data'=>json_encode($postSapData),'status'=>3,'type'=>"FixedPrice" ]);
            }elseif(@$result->status == "Success"){
                DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>1,'type'=>"FixedPrice" ]);
            }else{
                DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>2,'type'=>"FixedPrice" ]);
                continue;
            }
            DB::table("seatbased_sap_response")->insert([
                'sap_id'=>$result->sapReference,
                'sap_response'=>json_encode($result),
                'post_data'=>json_encode($postSapData),
                'users'=>json_encode($value->pluck('SalesEmployee')),
            ]); 
        } 
        return response()->json(['status'=>200,'message'=>"success"]);
    }
}
