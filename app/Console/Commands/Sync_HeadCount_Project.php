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
class Sync_HeadCount_Project extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Sync_HeadCount_Project:cron';

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
        foreach($users as $row){  
            try{
                $user = DB::table('latest_users')->where('HRMSID' ,@$row->EMPLOYEE_ID)->first();                
                if($user){
                    $update = DB::table('latest_users')->where('HRMSID',@$row->EMPLOYEE_ID)->update([
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
                        'campaign' =>@$row->COMPAIGN,
                        'status' =>2
                    ]);
                    if($update !== false){                       
                        $postdata['APIKey'] = "$%fsdfkbAusfiewrg93485#&^";
                        $postdata['salesEmployeeName'] = $user->emp_name;
                        $postdata['u_EmployeeID'] =  (string) $user->HRMSID;
                        $postdata['teamLeadID'] =  (string) $user->teamlead_id;
                        $postdata['teamLeadName'] =  (string) $user->teamlead_name;
                        $postdata['managerID'] =  (string) $user->manager_id;
                        $postdata['managerName'] =  (string) $user->manager_name;
                        $postdata['directorID'] =  (string) $user->manager_name;
                        $postdata['directorName'] =  (string) $user->manager_name;
                        $url="http://tsc.isap.pk:9001/api/Revenue/UpdateSalesPerson";   
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
                        if(strtolower ($result->status) == "success" || @$result->errorMsg == "This entry already exists in the following tables (ODBC -2035)"){
                            DB::table('latest_users')->where('HRMSID',$user->HRMSID)->update(['status'=>1]);
                        }    
                        $response[] = $result; 
                        curl_close($ch); 
                    }
                }else{
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
                    $postdata['APIKey'] = "$%fsdfkbAusfiewrg93485#&^";
                    $postdata['SalesEmployeeName'] = $user->emp_name;
                    $postdata['U_EmployeeID'] =  (string) $user->HRMSID;
                    $postdata['TeamLeadID'] =  (string) $user->teamlead_id;
                    $postdata['TeamLeadName'] =  (string) $user->teamlead_name;
                    $postdata['ManagerID'] =  (string) $user->manager_id;
                    $postdata['ManagerName'] =  (string) $user->manager_name;
                    $postdata['DirectorID'] =  (string) $user->manager_name;
                    $postdata['DirectorName'] =  (string) $user->manager_name;
                    $url="http://tsc.isap.pk:9001/api/Revenue/SalesPerson";   
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
                    if(strtolower ($result->status) == "success" || @$result->errorMsg == "This entry already exists in the following tables (ODBC -2035)"){
                        DB::table('latest_users')->where('HRMSID',$user->HRMSID)->update(['status'=>1]);
                    } 
                    curl_close($ch); 
                }
                
            }catch (\Exception $e) {
                continue;
            } 
        } 
          
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

 
        $projects  = \DB::table('projects') ->get();
        foreach($projects as $project){ 
            $postdata['APIKey'] = "$%fsdfkbAusfiewrg93485#&^";
            $postdata['Code'] =  (string)$project->project_code;
            $postdata['Name'] =  (string) $project->name;
            // return $postdata;
            $url="http://tsc.isap.pk:9001/api/Revenue/Projects";   
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
                // DB::table('projects')->where('id',$project->id)->update(['sap_status'=>1]);
            }

        }
        return $response;
    }
}
