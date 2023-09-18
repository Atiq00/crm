<?php

namespace App\Exports;

use App\Models\SaleRecord; use DB;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView; 
use Maatwebsite\Excel\Concerns\Exportable; 
use Maatwebsite\Excel\Concerns\ShouldAutoSize; 
use Maatwebsite\Excel\Concerns\WithHeadings;use Auth;
class ExportSolar implements FromView, ShouldAutoSize
{
    protected $start_date=''; 
    protected $end_date='';    
	protected $search='';
    protected $client_id='';    
	protected $project_id='';


    public function __construct($start_date=null,$end_date=null,$search=null,$client_id=null,$project_id=null,$id=null){
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->search = $search;
        $this->client_id = $client_id;       
        $this->project_id = $project_id;   

    }

    public function view(): View
    { 
        // echo $this->project_id;exit;
        $search=$this->search;
        $saleSolars = SaleRecord::with('client','project');
        
        if($this->search){        
            $saleSolars =$saleSolars->where(function($query)use($search){
                $query->where('phone','LIKE',"%".@$search."%");
                $query->orWhere('last_name','LIKE',"%".@$search."%");            
                $query->orWhere('first_name','LIKE',"%".@$search."%");            
            });
        }if($this->start_date && $this->end_date ){
            $saleSolars = $saleSolars->whereDate('created_at',">=",$this->start_date)->whereDate('created_at',"<=",$this->end_date);
        }
        if($this->client_id){
            $saleSolars = $saleSolars->where('client_code',$this->client_id);
        }
        if($this->project_id){
            $saleSolars = $saleSolars->where('project_code',$this->project_id);
        } 
		if(auth()->user()->hasRole("SolarClient")){
			
			$project_codes = User::with('projects')->where('id',auth()->user()->id)->get()
				->pluck('projects')->flatten()->pluck('project_code');
			 if($project_codes){
				 $saleSolars  =   $saleSolars->where('campaign_id',"2")->whereIn('project_code',$project_codes); 
			 }
		}
            
        $saleSolars = $saleSolars->get();
        // if(auth()->user()->hasRole("Super Admin")){
        //   echo $this->client_id."<br>";
        //   echo $this->project_id."<br>";
        //   echo $this->start_date."<br>";
        //   echo $this->end_date."<br>";
        //   echo "<pre>"; print_r($saleSolars);exit;
        // }
        
        return view('admin.solar.export', compact('saleSolars'));
    }
     
}