<?php

namespace App\Exports;

use App\Models\SaleMortgage; use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Contracts\View\View;
use App\User;
use Maatwebsite\Excel\Concerns\FromView; 
use Maatwebsite\Excel\Concerns\Exportable; 
use Maatwebsite\Excel\Concerns\ShouldAutoSize; 
use Maatwebsite\Excel\Concerns\WithHeadings;
class ExportMortgage implements FromView, ShouldAutoSize
{
    protected $start_date=''; 
    protected $end_date='';
    public function __construct($start_date=null,$end_date=null,$search=null,$client_id=null,$project_id=null){
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->search = $search;
        $this->client_id = $client_id;
        $this->project_id = $project_id;
    }

    public function view(): View
    { 
        $search= $this->search;
        $saleMortgages = SaleMortgage::with('client:id,name');
        if($this->start_date && $this->end_date ){
            $saleMortgages = $saleMortgages->whereDate('created_at',">=",$this->start_date)->whereDate('created_at',"<=",$this->end_date);
        }
        if($this->search){        
            $saleMortgages =$saleMortgages->where(function($query)use($search){
                $query->where('phone','LIKE',"%".@$search."%");
                $query->orWhere('last_name','LIKE',"%".@$search."%");            
                $query->orWhere('first_name','LIKE',"%".@$search."%");            
            });
        }
        if($this->client_id){
            $saleMortgages = $saleMortgages->where('client_code',$this->client_id);
        }
        if($this->project_id){
            $saleMortgages = $saleMortgages->where('project_code',$this->project_id);
        }
        if(auth()->user()->hasRole("MortgageClient")){
            
			if($this->project_id){
                $saleMortgages = $saleMortgages->where('project_code',$this->project_id);
            }else{
                $project_codes = User::with('projects')->where('id',auth()->user()->id)->get()->pluck('projects')->flatten()->pluck('project_code');
                if($project_codes){ 
                    $saleMortgages  =   $saleMortgages->where('campaign_id',"3")->whereIn('project_code',$project_codes); 
                }
            }             
		}
        $saleMortgages = $saleMortgages->get();
        return view('admin.mortgage.export', compact('saleMortgages'));
    }
     
}