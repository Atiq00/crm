<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecordDetail; use DB;
use App\Models\Campaign;
use App\Models\Client;
use App\Models\Project;
use App\HeadCount;
use App\Imports\UpdateBillableStatus;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Role; 
use App\Models\SaleRecord;
use App\Models\SaleMortgage;
use App\Models\HomeWarranty;
use Illuminate\Support\Facades\Http;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use App\Models\EmployeeHeadcount;

json_decode(file_get_contents("php://input"));
class ApiController extends Controller
{
    public function search_record(Request $request){
        try{
			if($request->table == 'sale_records'){
				$days_count = 120;				
			}else{
				$days_count = 90;
			}
            $phone=$request->record_id;
            $last_three_month = \Carbon\Carbon::now()->startOfMonth()->subMonth(4);$this_month = \Carbon\Carbon::now()->startOfMonth(); 

			$date = \Carbon\Carbon::today()->subDays($days_count);
			$count = DB::table($request->table)                        
                        ->where(function($query) use($phone) {
                            $query->where('phone',$phone)->orWhere('record_id',$phone);
                        })
                        ->whereNull('deleted_at')                       
                        ->where('created_at','>=',$date)->count();	
			
 			$old_sales = DB::table('phone_numbers')->where('phone',$request->record_id)->count();
			 

            if($count > 0 || $old_sales > 0){ 
                $response['message'] ="Phone Number Already Used";
                $response['status'] = 204;
                return response()->json($response);
            }
			//$res = RecordDetail::where("ID",$request->record_id)->orWhere('Phone',$request->record_id)->first();
			
            /*$qry_result =DB::select("SET @rec_id= ?; 
            SELECT DISTINCT
            CASE 
            WHEN record_id = @rec_id THEN '1'
            ELSE '0'
            END As Text
            FROM sale_mortgages where record_id=@rec_id, [$request->record_id]"
            var_dump($qry_result);
            */			
			$res = $this->get_record($phone);
            if($res->ID > 0 || $res->Phone > 0){
                $response['data'] =$res;
                $response['status'] = 200;
				//$response['count'] = $count;
                return response()->json($response,200);
            }else{
                $response['message'] ="Record Does not exist";
                $response['status'] = 204;
                return response()->json($response);
            }
            
        }catch (\Exception $e) {
            return response()->json([
                'status'  => '500',
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
				'response' => @$res,
            ],500);
        }
        
    }
    
	public function qa_records(Request $request){
        try{ 
			 
			if($request->id ==1){
                // return $request->id;
				$res = HomeWarranty::select('id','project_code','client_code','record_id','phone','hrms_id','campaign_id','client','created_at') 
					->with('campaign:id,name','client','project','user');
                if(@$request->from_date && @$request->to_date){ 
                    $res = $res->whereDate('created_at','>=',$request->from_date)->whereDate('created_at','<=',$request->to_date);
                }
                $res = $res->where('qa_status','Pending')->where('record_id',"Not Like","%SM%")->orderBy('created_at','DESC')->get();
                return response()->json($res); 
			}elseif($request->id ==2){ 
				$res = SaleRecord::select('id','project_code','client_code','record_id','phone','user_id','campaign_id','created_at')
				->with('campaign:id,name','client','project','user');
                if(@$request->from_date && @$request->to_date){
                    $res = $res->whereDate('created_at','>=',$request->from_date)->whereDate('created_at','<=',$request->to_date);
                }
                $res = $res->where('qa_status','Pending')->where('record_id',"Not Like","%SM%")->orderBy('created_at','DESC')->get(); 
                return response()->json($res); 
			}
			elseif($request->id ==3){
				$res = SaleMortgage::select('id','project_code','client_code','phone','record_id','user_id','campaign_id','created_at')
				->with('campaign:id,name','client','project','user');
                if(@$request->from_date && @$request->to_date){
                    $res = $res->whereDate('created_at','>=',$request->from_date)->whereDate('created_at','<=',$request->to_date);
                }
                $res = $res->where('qa_status','Pending')->where('record_id',"Not Like","%SM%")->orderBy('created_at','DESC')->get();
                return response()->json($res); 
			} else{
                // return response()->json([
                //     'status'  => '200',
                //     'message' => 'No Data Found', 
                // ],200);
                return response()->json([]); 
            }
             
            
        }catch (\Exception $e) {
            return response()->json([
                'status'  => '500',
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ],500);
        }
        
    }
    public function changeStatus(Request $request){
		if($request->isFixed == 0)
			$value = date('Y-m-d H:s:i');
		elseif($request->isFixed == 1)
			$value=null;
        $res = DB::table('projects')->where('id',$request->id)->limit(1)->update(['deleted_at' => $value]);
        return response()->json([
            'status'  => '200',
            'message' => 'success', 
        ],200);
    }
    public function updateQmsStatus(Request $request){ 
        // return $request;
        try{
            if($request->record_id <=0){
               $response['message'] ="Invalid Record ID";
               $response['status'] = 400;
               return response()->json($response);
            }
            $campaign = Campaign::with('clients')->where('id',$request->campaign_id)->first();
            if($campaign){
                $status='erro';
                if($request->outcome == "rejected")
                    $status="not-billable";
                elseif($request->outcome == "accepted")
                    $status="billable"; 
                elseif($request->outcome == "pending")
                    $status="pending"; 
                
                $table = $campaign->table_name;
                $res = DB::table($table)->where('record_id',$request->record_id)->limit(1)->update(['qa_status' => $status]);
                if($res){
                    $response['message'] ="Audit Done Successfully";
                    $response['status'] = 200;
                    return response()->json($response,200);
                }else{
                    $response['message'] ="The Audit for this Record ID has already been done.";
                    $response['status'] = 400;
                    return response()->json($response);
                }
            }else{
                return response()->json([
                    'status'  => 500,
                    'message' => 'Request Failed! Campaign_id does not exist'
                ]);
            }
        }catch (\Exception $e) {
            return response()->json([
                'status'  => '500',
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ],500);
        }
        
        
    }

    
    function changeStatusClient(Request $request){
		\DB::table($request->table)->where('id',$request->id)->limit(1)->update(['client_status'=>$request->client_status,'notes'=>$request->remarks]);
		return ['status'=>200,"message"=>"success"];
	}
    public function campaigns(Request $request){
        $campaigns = Campaign::wherein('id',[1,2,3])->get();
        if(!$campaigns->isEmpty()){
            $data['data'] = $campaigns;
            $data['status'] = "200";
        }else{
            $data['message'] ="Campaigns not found";
            $data['status'] = "204";
        }
        return response()->json($campaigns);
    }

    public function test(Request $request){
        $ids = \DB::table('users')->where('campaign',"LIKE","%"."home"."%")->pluck('id');
         
        foreach($ids as $id){
            $check = \DB::table('model_has_roles')->where('model_id',$id)->where('role_id',6)->first();
            if($check)
            continue;
            \DB::table("model_has_roles")->insert([
                'role_id'=>6,
                'model_type'=>"App\User",
                'model_id'=>$id
            ]);
        }
        exit;
        

        // return $data;
        foreach($data as $rw){
            $check = \DB::table('users')->where('HRMSID',@$rw['EMPLOYEE_ID'])->first();
            if($check)
            continue;
            $text = rand(100000,200000);
            $hash = \Hash::make($text);
            \DB::table('users')->insert([
                'name'=>@$rw['FIRST_NAME']." ".@$rw['LAST_NAME'],
                'email'=>(@$rw['EMAIL_ADDRESS']) ?(@$rw['EMAIL_ADDRESS']):"example@touchstone.com.pk", 
                'HRMSID'=>@$rw['EMPLOYEE_ID'],
                'birth_date'=>@$rw['BIRTH_DATE'],
                'cnic'=>@$rw['CNIC'],
                'password'=>$hash,
                'pass_text'=>$text,
                'employee_status'=>@$rw['EMPLOYEE_STATUS'],
                'joining_date'=>@$rw['JOINING_DATE'],
                'employee_status'=>@$rw['EMPLOYEE_STATUS'],
                'reporting_to_id'=>@$rw['REPORTING_TO_ID'],
                'employee_status'=>@$rw['EMPLOYEE_STATUS'],
                'designation'=>@$rw['DESIGNATION'],
                'campaign'=>@$rw['COMPAIGN'],
            ]);
        };

         
    }


    public function searchRecords(Request $request){
        $campaign = Campaign::where('id',$request->campaign_id)->first();
        $records = DB::table($campaign->table_name)->where('record_id',$request->record_id)->first();
        if($records){
			if($request->campaign_id==1){
				$user_id=@$records->hrms_id;
			}else{
				$user_id=@$records->user_id;
			}
            $records->agent_user=DB::table('users')->where('HRMSID',$user_id)->first();
            $records->client=DB::table('clients')->where('client_code',@$records->client_code)->first();
            $records->project=DB::table('projects')->where('project_code',@$records->project_code)->first();
            $records->campaign=DB::table('campaigns')->where('id',@$records->campaign_id)->first();
            $data['data'] = $records;
            $data['status'] = "200";
        }else{
            $data['message'] ="records not found";
            $data['status'] = "204";
        }
        return response()->json($records);
    }
    public function projects(Request $request){
        $record = Campaign::where('id',$request->campaign_id)->first(); 
        $clients = Client::where('campaign_id',$record->id)->pluck('id'); 
        $projects = Project::with('client')->whereIn('client_id',$clients)->get(); 
        return response()->json($projects);
    }
    public function select_electric(Request $request){ 
        return $projects = DB::table('electric_provider')->where('state',$request->val)->get();  
    }

    public function selectClient(Request $request){
        if(@$request->client_id){
            $client = \DB::table('clients')->where("client_code",$request->client_id)->first();
            return $data['res'] = \DB::table('projects')->where("client_id",$client->id)->get();
        }else{
            return $data['res'] = [];
        }
        
    }
    
    public function eddysales(){
        set_time_limit(0);$test =array(); 
        $arrayData=array();
        $sales = DB::table('eddy_sales')->leftjoin('eddy_users','eddy_users.agent_name','eddy_sales.agent_id')			
                ->select('agent_id','eddy_sales.id','eddy_sales.billable_hours','eddy_sales.created_at','sale_date','eddy_users.HRMSID as 
				        SalesEmployee','eddy_sales.client_code','eddy_sales.project_code')           
              ->where('billable_hours',">",0)
              ->where('sap_id',0)
              ->whereDate('sale_date',">=","2023-02-01")  
              ->whereDate('sale_date',"<=","2023-02-28")  
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
    public function seatbased(){  
        return  Client::addSelect([
            'last_project'=>Project::select('name')
            ->whereColumn('client_id','clients.id')
            ->orderByDesc('created_at')->limit(1)
            ])
        ->get();   
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
            $postSapData['DocumentLines']=$singlePacket; 
            $test [] =$postSapData;//return $postSapData;
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
        return $test;
        return response()->json(['status'=>200,'message'=>"success"]);
    }

    public function cmusales(){
        // return DB::table('cmu_sales')->pluck('hrms_id');
        $arrayData=array();
        $sales = DB::table('cmu_sales')
                ->select('project_code as ItemCode','count AS Quantity')
                ->selectRaw("
                            hrms_id as SalesEmployee, 
                            created_at as DocDate
                        ")                        
                ->where('sap_id',0)        
                ->where('hrms_id',">",0)   
                ->whereDate('created_at',">=","2023-01-01")     
                ->groupBy('hrms_id','created_at','project_code')
                ->get();      
            $userIds=array();      
        foreach($sales as $sale){
            if($sale->Quantity<=0){
                continue;
            }   
            $rw['ItemCode']=(string)$sale->ItemCode;
            $rw['Quantity']= $sale->Quantity; 
            $rw['QABillable']="0";
            $rw['QANonBillable']="0"; 
            $rw['QAPending']="0";
            $rw['ClientPending']="0"; 
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
            $postSapData['CardCode']="CUS-100028";              
            $postSapData['DocumentLines']=$value;
            $data['CardCode']="CUS-100028"; 
            $data['DocumentLines']=$postSapData; // return $postSapData;
            $url="http://tsc.isap.pk:9001/api/Revenue";   
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
                DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>0,'type'=>"Mortgage" ]);
            }elseif(@$result->status == "Success"){
                DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>1,'type'=>"Mortgage" ]);
            }else{ 
                DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>2,'type'=>"Mortgage" ]); 
            }
            if(@$result->status == "Success"){
                foreach($value as $rw){  
                    $ids =  DB::table("cmu_sales")->where('hrms_id',$rw['SalesEmployee'])
                            ->where('sap_id',0)->where('client_status',"billable")->where('client_code',"CUS-100028")
                            ->whereDate("created_at",date("Y-m-d",strtotime($key)))->pluck('id');

                    DB::table("cmu_sales")->whereIn('id',$ids)->update([
                        'sap_id'=>$result->sapReference,
                        'sap_response'=>json_encode($result),
                        'post_data'=>json_encode($postSapData),
                    ]);
                }
                
            }  
        } 
            // return $arrayData;  
        return response()->json(['status'=>200,'message'=>"success"]);
    }

    public function crusales(){
        set_time_limit(0);$test =array(); 
        $arrayData=array();
        $sales = DB::table('cru_sales')->join('cru_agent_details','cru_agent_details.cru_id','cru_sales.agent_name')->selectRaw("
            agent_name,
            cru_agent_details.hrms_id,
            Count(cru_sales.id) AS Quantity ,cru_sales.created_at              
        ")
        ->whereDate('cru_sales.created_at',">=","2023-02-01")  
        ->whereDate('cru_sales.created_at',"<=","2023-02-10")   
        ->where('sap_id',0)->groupBy('created_at','agent_name')->get()->groupby('created_at'); 
        foreach($sales as $key => $value){  
             
            $postSapData=array();  $ids =[];
            $postSapData['APIKey']="$%fsdfkbAusfiewrg93485#&^";
            $postSapData['DocDate']=date("Y-m-d",strtotime($key));
            $postSapData['CardCode']="CUS-100058"; 
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
            if(@$result->statusCode == 100 || @$result->statusCode == 101 || @$result->statusCode == 102 || @$result->statusCode == 103){
                if(@$result->data){
                    foreach(@$result->data as $item){
                        \DB::table('missing_items')->insert([
                            'statusCode' =>@$result->statusCode,
                            'missing_code' =>@$item
                        ]);
                    }
                }
            }
            DB::table("cru_sales")->whereIn('agent_name',$ids)->where('created_at',$key)->update([
                'sap_id'=>(@$result->sapReference) ? @$result->sapReference:0,
                'sap_response'=>json_encode($result),
                'post_data'=>json_encode($postSapData),
            ]);
            
        }  
        return response()->json(['status'=>200,'message'=>"success"]); 
    }
    public function caxsales(){
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
            
            DB::table("call_analytic_sales")->whereIn('id',$ids)->where('created_at',$key)->update([
                'sap_id'=>(@$result->sapReference) ? @$result->sapReference:0,
                'sap_response'=>json_encode($result),
                'post_data'=>json_encode($postSapData),
            ]);
            
        }  
        return response()->json(['status'=>200,'message'=>"success"]); 
    }
    public function sapDataSolar(Request $request){  
        // mail("myounus@touchstone.com.pk","Cron Test Solar","Test Cron Job Solar");
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
                ->whereDate('created_at',"<=","2023-02-28")  
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
                    // mail("myounus@touchstone.com.pk","Cron Job Solar", "SapResPonse:".json_encode($result)."<br>"."PostData:".json_encode($postSapData));
                    DB::table('sap_logs')->insert(['sap_response'=>json_encode(@$result), 'sap_post_data'=>json_encode($postSapData),'status'=>3,'type'=>"Solar" ]);
                }elseif(@$result->status == "Success"){
                    DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>1,'type'=>"Solar" ]);
                }else{
                    // mail("myounus@touchstone.com.pk","Cron Job Solar", "SapResPonse:".$result."<br>"."PostData:".json_encode($postSapData));
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
    public function sapDataToMortgage(Request $request){         
        try{
            set_time_limit(0);$test =array();$response = array();
            $clients = DB::table('sale_mortgages')->groupBy('client_code')->whereDate('created_at',">=","2023-01-01")->pluck('client_code'); 
            foreach($clients as $row){
                    $sales = DB::table('sale_mortgages')
                    ->select('client_code as CardCode','project_code as ItemCode')
                    ->selectRaw("
                                Count(CASE WHEN sale_mortgages.client_status = 'billable' THEN 1 ELSE NULL END) AS Quantity,
                                Count(CASE WHEN sale_mortgages.qa_status = 'billable' THEN 1 ELSE NULL END) AS QABillable,
                                Count(CASE WHEN sale_mortgages.qa_status = 'non-billable' THEN 1 ELSE NULL END) AS QANonBillable,
                                Count(CASE WHEN sale_mortgages.qa_status = 'pending' THEN 1 ELSE NULL END) AS QAPending,
                                Count(CASE WHEN sale_mortgages.client_status = 'pending' THEN 1 ELSE NULL END) AS ClientPending,
                                user_id as SalesEmployee, 
                                created_at as DocDate                  
                                ")
                    ->where('client_code',$row)  
                    ->whereDate('created_at',">=","2023-02-01")  
                    ->whereDate('created_at',"<=","2023-02-28")  
                    ->where('sap_id',"0")  
                    ->whereDate('created_at',">=","2023-02-01")->groupBy('user_id','created_at','project_code')
                    ->get();      
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
                    $response[] = $result;
                    if(@$result->status == "Error"){
                        // mail("myounus@touchstone.com.pk","Cron Job Mortgage", "SapResPonse:".json_encode($result)."<br>"."PostData:".json_encode($postSapData));
                        DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>0,'type'=>"Mortgage" ]);
                    }elseif(@$result->status == "Success"){
                        DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>1,'type'=>"Mortgage" ]);
                    }else{
                        // mail("myounus@touchstone.com.pk","Cron Job Mortgage", "SapResPonse:".$result."<br>"."PostData:".json_encode($postSapData));
                        DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>2,'type'=>"Mortgage" ]);
                        continue;
                    }
                    foreach($value as $rw){  
                        $ids =  DB::table("sale_mortgages")
                                ->where('user_id',$rw['SalesEmployee'])
                                ->where('client_status',"billable")
                                ->where('sap_id',0)
                                ->where('project_code',$rw['ItemCode'])
                                ->whereDate("created_at",date("Y-m-d",strtotime($key)))->pluck('id');

                        DB::table("sale_mortgages")->whereIn('id',$ids)->update([
                            'sap_id'=>@$result->sapReference? @$result->sapReference :0,
                            'sap_response'=>json_encode($result),
                            'sap_post_data'=>json_encode($postSapData),
                        ]);
                    }  
                } 
                
            } 
            // return $response;            
            return response()->json(['status'=>200,'message'=>"success"]);
        }catch(\Exception $e){
            // mail("myounus@touchstone.com.pk","Cron Test",$e->getMessage());
        }
    }
    public function sapDataWarranty(Request $request){  
        set_time_limit(0);$test =array();
        $arrayData=array();
        $sales = DB::table('home_warranties')
            ->select('client_code as CardCode','project_code as ItemCode')
            ->selectRaw("
                        Count(CASE WHEN home_warranties.client_status = 'billable' THEN 1 ELSE NULL END) AS Quantity,
                        Count(CASE WHEN home_warranties.qa_status = 'billable' THEN 1 ELSE NULL END) AS QABillable,
                        Count(CASE WHEN home_warranties.qa_status = 'non-billable' THEN 1 ELSE NULL END) AS QANonBillable,
                        Count(CASE WHEN home_warranties.qa_status = 'pending' THEN 1 ELSE NULL END) AS QAPending,
                        Count(CASE WHEN home_warranties.client_status = 'pending' THEN 1 ELSE NULL END) AS ClientPending,
                        hrms_id as SalesEmployee, 
                        created_at as DocDate
                    ")
            ->where('client_code',"CUS-100056")                       
            ->where('sap_id',0)
            ->whereDate('created_at',">=","2023-01-01")       
            ->groupBy('hrms_id','created_at','project_code')->get();      
        $userIds=array(); 
        if($sales->isEmpty()) {
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
                $data['CardCode']="CUS-100019"; 
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
                $response[] = $result;
                    if(@$result->status == "Error"){
                        mail("myounus@touchstone.com.pk","Cron Job HomeWarranty", "SapResPonse:".json_encode($result)."<br>"."PostData:".json_encode($postSapData));
                        DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>0,'type'=>"HomeWarranty" ]);
                    }elseif(@$result->status == "Success"){
                        DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>1,'type'=>"HomeWarranty" ]);
                    }else{
                        // mail("myounus@touchstone.com.pk","Cron Job HomeWarranty", "SapResPonse:".$result."<br>"."PostData:".json_encode($postSapData));
                        DB::table('sap_logs')->insert(['sap_response'=>json_encode($result), 'sap_post_data'=>json_encode($postSapData),'status'=>2,'type'=>"HomeWarranty" ]);
                        continue;
                    }
                foreach($value as $rw){  
                    $ids =  DB::table("home_warranties")
                        ->where('hrms_id',$rw['SalesEmployee'])
                        ->where('sap_id',0)->where('client_status',"billable")
                        ->where('client_code',"CUS-100056")
                        ->whereDate("created_at",date("Y-m-d",strtotime($key)))
                        ->pluck('id');  
                    DB::table("home_warranties")->whereIn('id',$ids)->update([
                        'sap_id'=>@$result->sapReference ? @$result->sapReference :0,
                        'sap_response'=>json_encode($result),
                        'sap_post_data'=>json_encode($postSapData),
                    ]);
                } 
            } 
        }         
        return response()->json(['status'=>200,'message'=>"success"]);
       
        
    }

	public function get_record($record_id){
			//$record_id = $request->record_id;
			$url = "http://115.186.128.55/api/?record_id=".$record_id;	
			$client = curl_init($url);
			curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
			$response = curl_exec($client);
			$result = json_decode($response);
			return $result;
		   //return response()->json(['status'=>200,'message'=>"success", 'data' => $result]);
	}
	
	public function all_debt_records(Request $request){
        try{ 
		 
			$search=$request->search;
			if($request->search){				
				$res =  SaleMortgage::select('*')->where('project_code','PRO0105')
						 ->where('phone','LIKE',"%".@$search."%")
						 ->orderBy('created_at','DESC')->paginate(50);
			}else{
				$res = SaleMortgage::select('*')->where('project_code','PRO0105')->orderBy('created_at','DESC')->paginate(50);
			}
			  			
            return response()->json($res); 
        }catch (\Exception $e) {
            return response()->json([
                'status'  => '500',
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ],500);
        }
        
    }
    public function all_cm_records(Request $request){
        try{ 
        
        $search=$request->search;
        if($request->search){				
            $res =  SaleMortgage::select('*')->where('project_code','PRO0105')
                ->where('phone','LIKE',"%".@$search."%")
                ->orderBy('created_at','DESC')->paginate(50);
        }else{
            $res = SaleMortgage::select('*')->where('project_code','PRO0105')->orderBy('created_at','DESC')->paginate(50);
        }
                
                return response()->json($res); 
            }catch (\Exception $e) {
                return response()->json([
                    'status'  => '500',
                    'message' => 'Request Failed',
                    'server_error' => $e->getMessage(),
                ],500);
            }
        
    }
    public function all_debt_shea_records(Request $request){
        try{  
        $search=$request->search;
        if($request->search){				
            $res =  SaleMortgage::select('*')->where('project_code','PRO0148')
                ->where('phone','LIKE',"%".@$search."%")
                ->orderBy('created_at','DESC')->paginate(50);
        }else{
            $res = SaleMortgage::select('*')->where('project_code','PRO0148')->orderBy('created_at','DESC')->paginate(50);
        }
            
            return response()->json($res); 
        }catch (\Exception $e) {
            return response()->json([
                'status'  => '500',
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ],500);
        }
        
    }
    public function all_debt_john_records(Request $request){
        try{  
        $search=$request->search;
        if($request->search){				
            $res =  SaleMortgage::select('*')->where('project_code','PRO0185')
                ->where('phone','LIKE',"%".@$search."%")
                ->orderBy('created_at','DESC')->paginate(50);
        }else{
            $res = SaleMortgage::select('*')->where('project_code','PRO0185')->orderBy('created_at','DESC')->paginate(50);
        }
            
            return response()->json($res); 
        }catch (\Exception $e) {
            return response()->json([
                'status'  => '500',
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ],500);
        }
        
    }
    public function all_debt_yaren_records(Request $request){
        try{  
        $search=$request->search;
        if($request->search){				
            $res =  SaleMortgage::select('*')->where('project_code','PRO0199')
                ->where('phone','LIKE',"%".@$search."%")
                ->orderBy('created_at','DESC')->paginate(500);
        }else{
            $res = SaleMortgage::select('*')->where('project_code','PRO0199')->orderBy('created_at','DESC')->paginate(500);
        }
            
            return response()->json($res); 
        }catch (\Exception $e) {
            return response()->json([
                'status'  => '500',
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ],500);
        }
        
    }
    public function solar_cm_nor_cali_records(Request $request){
        try{  
        $search=$request->search;
        if($request->search){				
            $res =  SaleRecord::select('*')->where('project_code','PRO0156')
                ->where('phone','LIKE',"%".@$search."%")
                ->orderBy('created_at','DESC')->paginate(50);
        }else{
            $res = SaleRecord::select('*')->where('project_code','PRO0156')->orderBy('created_at','DESC')->paginate(50);
        }
            
            return response()->json($res); 
        }catch (\Exception $e) {
            return response()->json([
                'status'  => '500',
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ],500);
        }
        
    }
    
    public function solar_asa_records(Request $request){
        try{  
        $search=$request->search;
        if($request->search){				
            $res =  SaleRecord::select('*')->where('project_code','PRO0180')
                ->where('phone','LIKE',"%".@$search."%")
                ->orderBy('created_at','DESC')->paginate(50);
        }else{
            $res = SaleRecord::select('*')->where('project_code','PRO0180')->orderBy('created_at','DESC')->paginate(50);
        }
            
            return response()->json($res); 
        }catch (\Exception $e) {
            return response()->json([
                'status'  => '500',
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ],500);
        }
        
    }

    public function solar_esd_records(Request $request){
        try{  
        $search=$request->search;
        if($request->search){				
            $res =  SaleRecord::select('*')->where('project_code','PRO0187')
                ->where('phone','LIKE',"%".@$search."%")
                ->orderBy('created_at','DESC')->paginate(50);
        }else{
            $res = SaleRecord::select('*')->where('project_code','PRO0187')->orderBy('created_at','DESC')->paginate(50);
        }
            
            return response()->json($res); 
        }catch (\Exception $e) {
            return response()->json([
                'status'  => '500',
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ],500);
        }
        
    }
    
    public function all_debt_jeff_records(Request $request){
        try{  
        // if($request->API_KEY != "36ca9bf0d6acc4f31223b714f07a6279")
        //   return response()->json([
        //     'status'  => '401',
        //     'message' => 'Un-Authorized Access', 
        //   ],200);
        $search=$request->search;
        if($request->search){				
            $res =  SaleMortgage::select('*')->where('project_code','PRO0149')
                ->where('phone','LIKE',"%".@$search."%")
                ->orderBy('created_at','DESC')->paginate(50);
        }else{
            $res = SaleMortgage::select('*')->where('project_code','PRO0149')->orderBy('created_at','DESC')->paginate(50);
        }
            
            return response()->json($res); 
        }catch (\Exception $e) {
            return response()->json([
                'status'  => '500',
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ],500);
        }
        
    }
	public function UpdateBillableStatus(){   
        if(auth()->user()->hasRole('Super Admin') && auth()->user()->HRMSID==916727){ 
            Excel::import(new UpdateBillableStatus(), request()->file('file'));
		    return redirect()->back()->with('success','clientLead Status Updated');
        }else{
            return ['success'=>401,'message'=>"Un-Authorize Access"];
        }
		
	}
    public function updateReocrId(){    

        // $responsePosting = "<response><result>failed</result><lead_id>OO9DXBNF</lead_id><price>0.00</price><msg>Lead Rejected</msg><errors><error>No Match</error></errors></response>";
        // $search = 'error';
        // if(preg_match("/{$search}/i", $responsePosting)) {  
        //     return 1;
        // } 
        return $check =    DB::table('sale_records')->whereNull('deleted_at')->where('phone',request('phone'))->whereDate('created_at',">=",date('Y-m-d',strtotime('-90 days')) )->first(); 


		$url="https://qmsv.touchstone-communications.com/api/getAllVoiceAudits";  
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($ch, CURLOPT_POST, 0);
        curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec ($ch);
        $result = json_decode($result);
        curl_close($ch);
        $leads =  $result->data;  
        $date =date('Y-m-d', strtotime(' -15 day'));
        foreach ($leads as $row) {             
            
            SaleRecord::where('record_id',$row->record_id)->update([
                'qa_score' =>$row->percentage,
                'qa_notes' =>$row->notes,
                'qa_status' =>($row->outcome == "rejected") ? "not-billable" :"billable"
            ]);
        
            SaleMortgage::where('record_id',$row->record_id)->update([
                'qa_score' =>$row->percentage,
                'qa_notes' =>$row->notes,
                'qa_status' =>($row->outcome == "rejected") ? "not-billable" :"billable"
            ]); 
                                   
        } 
        return true;
 
        // $url="https://qmsv.touchstone-communications.com/api/getAllVoiceAudits";  
        // $ch = curl_init();
        // curl_setopt ($ch, CURLOPT_URL, $url);
        // curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt ($ch, CURLOPT_POST, 0);
        // curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
        // curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        // $result = curl_exec ($ch);
        // $result = json_decode($result);
        // curl_close($ch);
        // $leads =  $result->data;  
        // $date =date('Y-m-d', strtotime(' -5 day'));
        // foreach ($leads as $row) {               
            
        //     SaleRecord::where('record_id',$row->record_id)->update([
        //         'qa_score' =>$row->percentage,
        //         'qa_notes' =>$row->notes,
        //         'qa_status' =>($row->outcome == "rejected") ? "not-billable" :"billable"
        //     ]);
        
        //     SaleMortgage::where('record_id',$row->record_id)->update([
        //         'qa_score' =>$row->percentage,
        //         'qa_notes' =>$row->notes,
        //         'qa_status' =>($row->outcome == "rejected") ? "not-billable" :"billable"
        //     ]); 
                                   
        // } 
                
        // return response()->json([
        //     'status'  => '200',
        //     'message' => 'Success', 
        // ],200);exit;

        
        
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPDebug  = 0;  
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;
        $mail->Host       = "smtp.googlemail.com";
        $mail->Username   = "noreply@equity-tap.com";
        $mail->Password   = "G00gleT@p";
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
        $mail->IsHTML(true);
        $mail->AddAddress("myounus@touchstone.com.pk", "Muhammad Younas");     

        $mail->SetFrom("noreply@equity-tap.com", "equitytapusa");  
        $mail->Subject = "HE Lend Test Email";
        $img_path = "public/he_img/thumbnail_image001.jpg";  
        $mail->AddEmbeddedImage($img_path, "thumbnail_image001");
        $content = "Hi "."Muhammad Younas".",<br>";
        $content .= "The process is very simple and best of all it will not affect your credit or cost you anything to unlock your preferred offer. Remember, we provide you a cash investment in exchange for a small percentage of your home's value. The best part is there are no monthly payments or interest. This program allows you to get the cash you need now and does not increase your monthly outgo. <br><br><br>"; 
        $content .= "There is no cost or obligation and if you decide to move forward there are no out-of-pocket cost including the appraisal. This is the best possible way to access cash now and we look forward to helping you unlock the offer that is right for you.<br><br><br>";
        $content .= "Unlock your offer by clicking the link below:  <a href='https://www.unlksite.com/DFBHL/GTSC3/'>Unlock your offer!</a>,<br><br><br>";        
        $content .= '<img src="cid:thumbnail_image001" style="height:100px"><br>';
        $content .= "Dalton Rosene Equity Specialist<br>";
        $content .= "dalton@equitytapusa.com<br>";
        $content .= "equitytapusa.com<br>";
        $content .= "P (949) 209-0786<br>";
        $content .= "P (949) 209-0745 <br>";
        $mail->isHTML(true); 
        $mail->MsgHTML($content); 
        if(!$mail->Send()) {
            echo "Error while sending Email."; 
        } else {
            echo "Email sent successfully";
        }
        exit; 
        
        // $address = 'Evacuee Trust Complex, Agha Khan Rd, F-5';  
        // $array = array();
        // $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false&key=AIzaSyCTbYZF_kDxKNopcvej6oh-eVs1z9Xq2J0');

        // // We convert the JSON to an array
        // $geo = json_decode($geo, true);

        // // If everything is cool
        // if ($geo['status'] = 'OK') {
        //     //   $latitude = $geo['results'][0]['geometry']['location']['lat'];
        //     //   $longitude = $geo['results'][0]['geometry']['location']['lng'];
        //     //   $array = array('lat'=> $latitude ,'lng'=>$longitude);
            
        // }

        // return $geo; 
        // $emial = \Mail::mailer('smtp1');
         


        exit;
        
          

        // $url="https://touchstone.smarthcm.com/ws/SmartHCMWS.asmx/GetEmployeeDetailList_SecurityCode?SecurityKey=admin@123&langCode=en_US";  
        // $ch = curl_init();
        // curl_setopt ($ch, CURLOPT_URL, $url);
        // curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt ($ch, CURLOPT_POST, 1);
        // curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
        // curl_setopt ($ch, CURLOPT_POSTFIELDS, "langCode=en_US&SecurityKey=admin@123");
        // curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        // $result = curl_exec ($ch);
        // curl_close($ch);  
       
        // $result = str_replace("diffgr:","DiffID",$result);
        // $xmlObject = simplexml_load_string($result);    
        // $result =json_decode(json_encode($xmlObject));
        // $users = $result->DiffIDdiffgram->NewDataSet->EmpTable; 
        // foreach($users as $row){  
        //     DB::table('latest_users')->insert([
        //         'name' =>@$row->FIRST_NAME." ".@$row->LAST_NAME,
        //         'email' =>@$row->EMAIL_ADDRESS,
        //         'HRMSID' =>@$row->EMPLOYEE_ID,
        //         'EMPLOYEE_ID' =>@$row->EMPLOYEE_ID,
        //         'birth_date' =>@$row->BIRTH_DATE,
        //         'cnic' =>@$row->CNIC,
        //         'employee_status' =>@$row->EMPLOYEE_STATUS,
        //         'joining_date' =>@$row->JOINING_DATE,
        //         'retirement_date' =>@$row->RETIREMENT_DATE,
        //         'reporting_to_id' =>@$row->REPORTING_TO_ID,
        //         'reporting_to_name' =>@$row->REPORTING_TO_NAME,
        //         'designation' =>@$row->DESIGNATION,
        //         'campaign' =>@$row->COMPAIGN
        //     ]);
        // } 
    }
    public function get_debt_record($id){
        try{ 
            $res = SaleMortgage::select('*')->where('project_code','PRO0105')->where('id',$id)->orderBy('created_at','DESC')->first(); 
            
            return response()->json($res); 
        }catch (\Exception $e) {
            return response()->json([
                'status'  => '500',
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ],500);
        }
            
    }	

    public function solar_project_records(Request $request){
        try{ 
		 
			$search=$request->search;
			if($request->search){				
				$res =  SaleMortgage::select('*')->where('project_code',$request->project_code)
						 ->where('phone','LIKE',"%".@$search."%")
						 ->orderBy('created_at','DESC')->paginate(50);
			}else{
				$res = SaleMortgage::select('*')->where('project_code',$request->project_code)->orderBy('created_at','DESC')->paginate(50);
			}
			  			
            return response()->json($res); 
        }catch (\Exception $e) {
            return response()->json([
                'status'  => '500',
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ],500);
        }
        
    }
    public function mortgage_project_records(Request $request){
        try{ 
		 
			$search=$request->search;
			if($request->search){				
				$res =  SaleMortgage::select('*')->where('project_code',$request->project_code)
						 ->where('phone','LIKE',"%".@$search."%")
						 ->orderBy('created_at','DESC')->paginate(50);
			}else{
				$res = SaleMortgage::select('*')->where('project_code',$request->project_code)->orderBy('created_at','DESC')->paginate(50);
			}
			  			
            return response()->json($res); 
        }catch (\Exception $e) {
            return response()->json([
                'status'  => '500',
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ],500);
        }
        
    }
    public function update_debt_record(Request $request){
        $id = $request->input('id');
        $id = (int)$id;
        $client_status = $request->input('client_status');
        $client_remarks = $request->input('remarks');
        $status = "";
        if($client_status=='accepted'){
            $status = "billable";
        }
        if($client_status=='rejected'){
            $status = "not-billable";
        }
        if($client_status=='pending'){
            $status = "pending";
        }
        //echo $request->input('client_status');
        if(SaleMortgage::where('id',$id)->update(['client_status'=> $status, 'client_remarks' => $client_remarks])){		
            return response()->json(['status'=>200,'message'=>"Updated successfully", 'id' => $id, 'client_status' => $status]);
        }else{
            return response()->json(['status'=>201,'message'=>"Not Updated", 'id' => $id, 'client_status' => $status]);
        }
    }
    public function update_solar_record(Request $request){
        $id = $request->input('id');
        $id = (int)$id;
        $client_status = $request->input('client_status');
        $client_remarks = $request->input('remarks');
        $status = "";
        if($client_status=='accepted'){
            $status = "billable";
        }
        if($client_status=='rejected'){
            $status = "not-billable";
        }
        if($client_status=='pending'){
            $status = "pending";
        }
        //echo $request->input('client_status');
        if(SaleRecord::where('id',$id)->update(['client_status'=> $status, 'client_remarks' => $client_remarks])){		
            return response()->json(['status'=>200,'message'=>"Updated successfully", 'id' => $id, 'client_status' => $status]);
        }else{
            return response()->json(['status'=>201,'message'=>"Not Updated", 'id' => $id, 'client_status' => $status]);
        }
    }
    
    public function getCampaigns()
    {
        $campaigns = Campaign::select('id', 'name', 'table_name', 'status')->get()->toJson();
        return response()->json([
            'success' => 200,
            'message' => 'All Campaigns',
            'data' => $campaigns
        ]);
    }
    public function getClients()
    {
        $clients = Client::select('id', 'client_code', 'name', 'campaign_id')->get()->toJson();
        return response()->json([
            'success' => 200,
            'message' => 'All Clients',
            'data' => $clients
        ]);
    }

    public function LatestHeadCount(){   
        // $res = DB::select("Select e.HRMSID,e.name emp_name,tl.HRMSID teamlead_id, tl.name teamlead_name, m.reporting_to_id manager_id, 
        //     m.reporting_to_name manager_name, d.reporting_to_id Director_id, d.reporting_to_name Director_name  from latest_users e 
        //     left join latest_users tl on e.reporting_to_id = tl.HRMSID 
        //     left join latest_users m on e.reporting_to_id = m.HRMSID 
        //     left join latest_users d on m.reporting_to_id = d.HRMSID");

        
        // $designations = DB::table('designations')->get();
        // foreach($designations as $row){
        //     try{
        //          DB::table('latest_users')->where('designation',$row->name)->update([ 
        //             'designation_id' =>$row->id
        //         ]);
        //     }catch(\Exception $e){
        //         continue;
        //     }
           
        // }
        $fileName = 'Attendance.csv';
        $tasks = DB::table('attendance')->select('attendance.id','latest_users.name as Name','attendance.HRMSID','Att_Date','Att_timeIn_timeOut') 
                ->leftjoin('latest_users','latest_users.HRMSID','=','attendance.HRMSID')->where('Att_timeIn_timeOut',"1")                 
                ->whereDate('attendance.created_at',">=","2023-01-25")->whereDate('attendance.created_at',"<=","2023-02-25")->get()->groupBy('HRMSID');
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $date = "2023-01-25";
        $date = strtotime($date);
        $columns = array('EmployeID', 'EmpName');
        for($i=1; $i<=31;$i++){                
            $columns []  = date('D ', strtotime("+$i day", ($date))).date('Y-m-d', strtotime("+$i day", ($date))); 
        } 
        $callback = function() use($tasks, $columns,$date) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);            
            foreach ($tasks as $key => $task) {
                // print_r($task);exit;
                if(!empty($task)){
                    $res = DB::table('latest_users')->where('HRMSID',$key)->first();
                    $row['EmployeID']  = $key ;                
                    $row['EmpName']    = @$res->name;                                 
                    $arr = array(
                        $row['EmployeID'],
                        $row['EmpName']                     
                    );                
                    for($i=1; $i<=31;$i++){  
                        $flag=0;
                        foreach($task as $tsk){
                            if(date('Y-m-d', strtotime("+$i day", ($date))) == date('Y-m-d', strtotime(@$tsk->Att_Date)) )
                            $flag=1;
                        }                 
                        
                        $arr[] = $flag;
                    } 
                    fputcsv($file, $arr);
                }                 
                
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
        
        
    }
    public function AllEmployeeData(){  

        $url="https://touchstone.smarthcm.com/ws/SmartHCMWS.asmx/GetEmployeeDetailList_SecurityCode?SecurityKey=admin@123&langCode=en_US";  
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, "langCode=en_US&SecurityKey=admin@123");
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        $result = curl_exec ($ch);
        curl_close($ch);  
       
        $result = str_replace("diffgr:","DiffID",$result);
        $xmlObject = simplexml_load_string($result);    
        $result =json_decode(json_encode($xmlObject));
        $users = $result->DiffIDdiffgram->NewDataSet->EmpTable; 
        // return  $users;
        DB::table('latest_users')->truncate();
        foreach($users as $row){  
            try{
                DB::table('latest_users')->insert([
                    'name' =>@$row->FIRST_NAME." ".@$row->LAST_NAME,
                    'email' =>@$row->EMAIL_ADDRESS,
                    'HRMSID' =>@$row->EMPLOYEE_ID,
                    'EMPLOYEE_ID' =>@$row->EMPLOYEE_ID,
                    'birth_date' =>@$row->BIRTH_DATE,
                    'cnic' =>@$row->CNIC,
                    'employee_status' =>@$row->EMPLOYEE_STATUS,
                    'joining_date' =>@$row->JOINING_DATE,
                    'retirement_date' =>@$row->RETIREMENT_DATE,
                    'reporting_to_id' =>@$row->REPORTING_TO_ID,
                    'reporting_to_name' =>@$row->REPORTING_TO_NAME,
                    'designation' =>@$row->DESIGNATION,
                    'campaign' =>@$row->COMPAIGN
                ]);
            }catch (\Exception $e) {
                continue;
            } 
        } 
         
        // $users = DB::select("Select e.HRMSID,e.name emp_name,tl.HRMSID teamlead_id, tl.name teamlead_name, m.reporting_to_id manager_id, m.reporting_to_name manager_name, 
        // d.reporting_to_id Director_id, d.reporting_to_name Director_name from latest_users e 
        // left join latest_users tl on e.reporting_to_id = tl.HRMSID 
        // left join latest_users m on e.reporting_to_id = m.HRMSID 
        // left join latest_users d on m.reporting_to_id = d.HRMSID;");
        // $response=array();
        // foreach($users as $user){ 
        //     $postdata['APIKey'] = "$%fsdfkbAusfiewrg93485#&^";
        //     $postdata['SalesEmployeeName'] = $user->emp_name;
        //     $postdata['U_EmployeeID'] =  (string) $user->HRMSID;
        //     $postdata['TeamLeadID'] =  (string) $user->teamlead_id;
        //     $postdata['TeamLeadName'] =  (string) $user->teamlead_name;
        //     $postdata['ManagerID'] =  (string) $user->manager_id;
        //     $postdata['ManagerName'] =  (string) $user->manager_name;
        //     $postdata['DirectorID'] =  (string) $user->manager_name;
        //     $postdata['DirectorName'] =  (string) $user->manager_name;

        //     // return $postdata;
        //     $url="http://tsc.isap.pk:9001/api/Revenue/SalesPerson";   
        //     $ch = curl_init();
        //     curl_setopt ($ch, CURLOPT_URL, $url);
        //     curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //     curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //     curl_setopt ($ch, CURLOPT_POST, 1);
        //     curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
        //     curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
        //     curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        //     curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1); 
        //     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8','Accept: application/json'));
        //     $result = curl_exec ($ch); 
        //     $result = json_decode($result); 
        //     if(strtolower ($result->status) == "success" || @$result->errorMsg == "This entry already exists in the following tables (ODBC -2035)"){
        //         DB::table('latest_users')->where('HRMSID',$user->HRMSID)->update(['status'=>1]);
        //     }

        //     $response[] = $result; 
        //     curl_close($ch); 

        // } 
        // return ['status'=>200,'data'=>$response];
        
    }

    public function AllProjectData(){ 


        $response=array();
        // $clients  = \DB::table('clients')->select('clients.name as name','client_code','campaigns.name as campaign_name')->leftjoin('campaigns','campaigns.id',"=","clients.campaign_id")->get();
        // foreach($clients as $client){ 
        //     $postdata['APIKey'] = "$%fsdfkbAusfiewrg93485#&^";
        //     $postdata['CardCode'] =  (string)$client->client_code;
        //     $postdata['CardName'] =  (string) $client->name; 
        //     $postdata['GroupName'] =  (string) $client->campaign_name; 
        //     $url="http://tsc.isap.pk:9001/api/Revenue/Customer";   
        //     $ch = curl_init();
        //     curl_setopt ($ch, CURLOPT_URL, $url);
        //     curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //     curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //     curl_setopt ($ch, CURLOPT_POST, 1);
        //     curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
        //     curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
        //     curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        //     curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1); 
        //     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8','Accept: application/json'));
        //     $result = curl_exec ($ch); 
        //     $result = json_decode($result);
        //     $result->postdata = $postdata;
        //     $response[] = $result;
        //     curl_close($ch); 
        //     if(strtolower ($result->status) == "success" || @$result->errorMsg == "This entry already exists in the following tables (ODBC -2035)"){
        //         // DB::table('clients')->where('id',$project->id)->update(['sap_status'=>1]);
        //     }

        // }
        // return $response;

 
        // $projects  = \DB::table('projects') ->get();
        // foreach($projects as $project){ 
        //     $postdata['APIKey'] = "$%fsdfkbAusfiewrg93485#&^";
        //     $postdata['Code'] =  (string)$project->project_code;
        //     $postdata['Name'] =  (string) $project->name;
        //     // return $postdata;
        //     $url="http://tsc.isap.pk:9001/api/Revenue/Projects";   
        //     $ch = curl_init();
        //     curl_setopt ($ch, CURLOPT_URL, $url);
        //     curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //     curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //     curl_setopt ($ch, CURLOPT_POST, 1);
        //     curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
        //     curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
        //     curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        //     curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1); 
        //     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8','Accept: application/json'));
        //     $result = curl_exec ($ch); 
        //     $result = json_decode($result);
        //     $result->postdata = $postdata;
        //     $response[] = $result;
        //     curl_close($ch); 
        //     if(strtolower ($result->status) == "success" || @$result->errorMsg == "This entry already exists in the following tables (ODBC -2035)"){
        //         // DB::table('projects')->where('id',$project->id)->update(['sap_status'=>1]);
        //     }

        // }
        // return $response;
    }

    public function AllCustomerData(){ 
        $response=array();
        $clients  = \DB::table('clients')->select('clients.name as name','client_code','campaigns.name as campaign_name')->leftjoin('campaigns','campaigns.id',"=","clients.campaign_id")->get();
        foreach($clients as $client){ 
            $postdata['APIKey'] = "$%fsdfkbAusfiewrg93485#&^";
            $postdata['CardCode'] =  (string)$client->client_code;
            $postdata['CardName'] =  (string) $client->name; 
            $postdata['GroupName'] =  (string) $client->campaign_name; 
            $url="http://tsc.isap.pk:9001/api/Revenue/Customer";   
            $ch = curl_init();
            curl_setopt ($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt ($ch, CURLOPT_POST, 1);
            curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8','Accept: application/json'));
            $result = curl_exec ($ch); 
            $result = json_decode($result);
            $result->postdata = $postdata;
            $response[] = $result;
            curl_close($ch); 
            if(strtolower ($result->status) == "success" || @$result->errorMsg == "This entry already exists in the following tables (ODBC -2035)"){
                // DB::table('clients')->where('id',$project->id)->update(['sap_status'=>1]);
            }

        }
        return $response;
    }
    public function removeNamespaceFromXML( $xml )
    {
        // Because I know all of the the namespaces that will possibly appear in 
        // in the XML string I can just hard code them and check for 
        // them to remove them
        $toRemove = ['rap', 'turss', 'crim', 'cred', 'j', 'rap-code', 'evic'];
        // This is part of a regex I will use to remove the namespace declaration from string
        $nameSpaceDefRegEx = '(\S+)=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?';

        // Cycle through each namespace and remove it from the XML string
        foreach( $toRemove as $remove ) {
            // First remove the namespace from the opening of the tag
            $xml = str_replace('<' . $remove . ':', '<', $xml);
            // Now remove the namespace from the closing of the tag
            $xml = str_replace('</' . $remove . ':', '</', $xml);
            // This XML uses the name space with CommentText, so remove that too
            $xml = str_replace($remove . ':commentText', 'commentText', $xml);
            // Complete the pattern for RegEx to remove this namespace declaration
            $pattern = "/xmlns:{$remove}{$nameSpaceDefRegEx}/";
            // Remove the actual namespace declaration using the Pattern
            $xml = preg_replace($pattern, '', $xml, 1);
        }

        // Return sanitized and cleaned up XML with no namespaces
        return $xml;
    }

    public function namespacedXMLToArray($xml)
    {
        // One function to both clean the XML string and return an array
        return json_decode(json_encode(simplexml_load_string($this->removeNamespaceFromXML($xml))), true);
    }
    public function getProjects()
    {
        $projects = Project::select('id', 'name', 'project_code', 'client_id')->get()->toJson();
        return response()->json([
            'success' => 200,
            'message' => 'All Projects',
            'data' => $projects
        ]);
    }

    public function allprojects(Request $request){
        try{  
        if($request->API_KEY != "36ca9bf0d6acc4f31223b714f07a6279")
            return response()->json([
            'status'  => '401',
            'message' => 'Un-Authorized Access', 
            ],200);

            $projects = Project::with('client:id,name,client_code')->get();   
            return response()->json([
            'status'  => '200',
            'data' => $projects, 
        ],200);
        }catch (\Exception $e) {
            return response()->json([
                'status'  => '500',
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ],500);
        }
        
    }
    public function all_users(Request $request){
        try{  
        if($request->API_KEY != "36ca9bf0d6acc4f31223b714f07a6279")
            return response()->json([
            'status'  => '401',
            'message' => 'Un-Authorized Access', 
            ],200);
            return response()->json([
            'status'  => '200',
            'data' => DB::table('sap_users')->select('id as ID',"HRMSID","EMPPOSITION","EMPNAME")->where('status',true)->get(), 
        ],200);
        }catch (\Exception $e) {
            return response()->json([
                'status'  => '500',
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ],500);
        }
        
    }
    public function changeStatusPci(Request $request){  
        DB::table('solar_pci')->where('id',$request->id)->update(['status' => $request->status]);  
        return ['status'=>200,'message'=>"update successfully"];
    }

    public function create_user(Request $request){
        // return $request;
        try{  
            if($request->API_KEY == "36ca9bf0d6acc4f31223b714f07a6279"){
                if(DB::table('users')->where('HRMSID',$request->hrmsid)->count()<=0){
                    DB::table('users')->insert([
                        'HRMSID'=>@$request->hrmsid,
                        'name'=>@$request->name,
                        'email'=>@$request->email,
                    ]);
                    return response()->json(['status'  => '201', 'message' => 'User Create Successfuly'],201); 
                } else{
                    return response()->json(['status'  => '200', 'message' => 'User already Exist'],200); 
                }                             

            }else{
                return response()->json([
                    'status'  => '401',
                    'message' => 'Un-Authorized Access', 
                ],401);
            }
        }catch (\Exception $e) {
            return response()->json([
                'status'  => '500',
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ],500);
        }
        
    }

    public function check_lead(Request $request){
        // echo date('Y-m-d',strtotime('-90 days'));
        try{  

            $solar = SaleRecord::with('user:name,email,HRMSID','project:id,name,project_code,created_at')->select('id','first_name','last_name','email','phone','record_id','user_id','project_code','created_at')->where('phone',$request->phone)->first();
            $mortgage = SaleMortgage::with('user:name,email,HRMSID')->select('id','first_name','last_name','email','phone','record_id','user_id','project_code','created_at')->where('phone',$request->phone)->first();
            $homewarranty = HomeWarranty::with('user:name,email,HRMSID')->select('id','first_name','last_name','phone','record_id','hrms_id','project_code','created_at')->where('phone',$request->phone)->first();
            
            $res_solar = DB::table('client_postings')->select('sale_id','post_response','created_at')->where('sale_id',@$solar->id)->where('campaign_id',2)->first();
            $res_morgt = DB::table('client_postings')->select('sale_id','post_response','created_at')->where('sale_id',@$mortgage->id)->where('campaign_id',3)->first();
            $res_hmwr =  DB::table('client_postings')->select('sale_id','post_response','created_at')->where('sale_id',@$homewarranty->id)->where('campaign_id',1)->first();
      
           
           
            if($solar){
                $data['solar'] = $solar;
                $data['posting'] = $res_solar;
                $data['project'] = DB::table('projects')->where('project_code',@$solar->project_code)->first();
            }
                
            if($mortgage){
                $data['mortgage'] = $mortgage;
                $data['posting'] = $res_morgt;
                $data['project'] = DB::table('projects')->where('project_code',@$mortgage->project_code)->first();
            }
                
            if($homewarranty){
                $data['homewarranty'] =$homewarranty;
                $data['posting'] = $res_hmwr;
                $data['project'] = DB::table('projects')->where('project_code',@$homewarranty->project_code)->first();
            }
                
           
            return response()->json([
                'status'  => '200',
                'data' => (@$data)?$data:"No rocord found", 
            ],200);
        }catch (\Exception $e) {
            return response()->json([
                'status'  => '500',
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ],500);
        }
        
    }

    public function pending_qa_counts(Request $request){
        if($request->API_KEY != "36ca9bf0d6acc4f31223b714f07a6279")
        return response()->json([
          'status'  => '401',
          'message' => 'Un-Authorized Access', 
        ],200);
        try{
            $data['home_warranty'] = HomeWarranty::where('qa_status','Pending')->where('record_id',"Not Like","%SM%")->orderBy('created_at','DESC')->count(); 
            $data['solar'] = SaleMortgage::where('qa_status','Pending')->where('record_id',"Not Like","%SM%")->orderBy('created_at','DESC')->count(); 
            $data['mortgage'] = SaleRecord::where('qa_status','Pending')->where('record_id',"Not Like","%SM%")->orderBy('created_at','DESC')->count();
            return response()->json([
                'status'  => '200',
                'data' => $data, 
            ],401);
        }catch (\Exception $e) {
            return response()->json([
                'status'  => '500',
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ],500);
        }
         
    }
	public function latestEmployeeHeadcount()
    {
        // $employees = EmployeeHeadcount::whereIn('campaign', ['Mortgage','Mortgage Vertical','Mortgage X', 'Solar', 'Solar X', 'Home Warranty', 'Operations Management', 'OPS MGMT'])->get();
        $employees = EmployeeHeadcount::all();
        return response()->json([
            'success' => 200,
            'total' => count($employees),
            'message' => 'HCM Users for Mortgage, Home Warranty and Solar',
            'data' => $employees,
        ]);
    }
}



  