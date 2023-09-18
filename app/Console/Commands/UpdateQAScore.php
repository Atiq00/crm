<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Client; use DB;
class UpdateQAScore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateQAScore:cron';

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
    }
}