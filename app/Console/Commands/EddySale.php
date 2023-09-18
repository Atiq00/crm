<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Client; use DB;
class EddySale extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'EddySale:cron';

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
        $sales = DB::table('eddy_sales')->leftjoin('eddy_users','eddy_users.agent_name','eddy_sales.agent_id')			
                ->select('agent_id','eddy_sales.id','eddy_sales.billable_hours','eddy_sales.created_at','sale_date','eddy_users.HRMSID as 
				        SalesEmployee','eddy_sales.client_code','eddy_sales.project_code')           
              ->where('billable_hours',">",0)
              ->where('sap_id',0)
              ->whereDate('sale_date',">=","2023-02-01")   
              ->get()->groupBy('sale_date');           
        foreach($sales as $key => $value){ 
            $postSapData=array();  $ids =[];
            $postSapData['APIKey']="$%fsdfkbAusfiewrg93485#&^";
            $postSapData['DocDate']="$key";
            $postSapData['CardCode']="CUS-100062"; 
            $singlePacket=array();
            foreach($value as $rw){
                if($rw->billable_hours==0 || $rw->project_code==null || $rw->project_code=='' || $rw->SalesEmployee==0)
                continue;
                $row['ItemCode']=$rw->project_code;
                $row['Quantity']= (float)$rw->billable_hours; 
                $row['QABillable']="0";
                $row['QANonBillable']="0"; 
                $row['QAPending']="0";
                $row['ClientPending']="0"; 
                $row['SalesEmployee']=(string)$rw->SalesEmployee;
                $row['QAScore']="0"; 
                $row['AgentCallsCount']="0"; 
                $singlePacket[]=$row;
                $ids[]=$rw->id;
            }         
            $postSapData['DocumentLines']=$singlePacket; 
            //return $postSapData;
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
                                'project' => "Eddy"
                            ]);
                        }
                    }
                }
                DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>0,'type'=>"Eddy" ]);
            }elseif(@$result->status == "Success"){
                DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>1,'type'=>"Eddy" ]);
            }else{
                DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>2,'type'=>"Eddy" ]);
                continue;
            }
            if($result->status == "Success"){
                DB::table("eddy_sales")->whereIn('id',$ids)->update([
                    'sap_id'=>$result->sapReference,
                    'sap_response'=>json_encode($result),
                    'post_data'=>json_encode($postSapData), 
                ]); 
            }else{
                DB::table("eddy_sales")->whereIn('id',$ids)->update([
                    'sap_id'=>0,
                    'sap_response'=>json_encode($result),
                    'post_data'=>json_encode($postSapData), 
                ]);
            }
        } 
        return response()->json(['status'=>200,'message'=>"success"]);
    }
}
