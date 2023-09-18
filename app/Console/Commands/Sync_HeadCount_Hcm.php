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
class Sync_HeadCount_Hcm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Sync_HeadCount_Hcm:cron';

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
                $name = @$row->FIRST_NAME." ".@$row->MIDDLE_NAME." ".@$row->LAST_NAME;
                $update = \DB::table('users')->where('HRMSID',@$row->EMPLOYEE_ID)->update([
                    'name' =>@$name,    
                    'employee_status' =>@$row->EMPLOYEE_STATUS,  
                    'reporting_to_id' =>@$row->REPORTING_TO_ID,
                    'reporting_to_name' =>@$row->REPORTING_TO_NAME,
                    'designation' =>@$row->DESIGNATION,
                    'campaign' =>@$row->COMPAIGN
                ]);  
            }catch (\Exception $e) {
                continue;
            } 
        } 
       
    }
}
