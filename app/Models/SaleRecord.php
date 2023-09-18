<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SaleRecord extends Model
{
    use SoftDeletes;
    protected $table="sale_records";
    protected $guarded =[];
    protected $appends=['posting'];

    public function user(){
        return $this->belongsTo('App\User', 'user_id','HRMSID');
    }

    public function client(){
        return $this->belongsTo('App\Models\Client', 'client_code','client_code');
    }

    public function campaign(){
        return $this->belongsTo('App\Models\Campaign', 'campaign_id','id');
    }
    public function project(){
        return $this->belongsTo('App\Models\Project', 'project_code','project_code');
    }
    protected $dates = [ 'deleted_at' ];
    public function scopeSearch($solars,$search,$start_date,$end_date,$client_id,$project_id,$user_id,$reporting_to){       
         
        if($search){        
            $solars =$solars->where(function($query)use($search){
                $query->where('phone','LIKE',"%".@$search."%");
                $query->orWhere('last_name','LIKE',"%".@$search."%");            
                $query->orWhere('first_name','LIKE',"%".@$search."%");            
            });
        }
        if($client_id){
            $solars = $solars->where('client_code',$client_id);
        }
        if($project_id){
            $solars = $solars->where('project_code',$project_id);
        }
        if($user_id){
            $solars = $solars->where('user_id',$user_id);
        }
        if($start_date && $end_date){
            $solars = $solars->whereDate('created_at',">=",$start_date)->whereDate('created_at',"<=",$end_date);
        } 
        if($reporting_to){
            $users = \DB::table('users')->where('reporting_to_id',$reporting_to)->pluck('HRMSID');
            $solars = $solars->whereIn('user_id',$users);
        }
        return $solars;
    }
    public function getPostingAttribute(){
        if($this->project_code == "PRO0033"){
            $xmlString='';
            $res = \DB::table('client_postings')->select('id','post_response')->where('sale_id',$this->id)->where('campaign_id',2)->first();
            if($res){
                $xmlString = $res->post_response;
                if($xmlString){
                    $xmlObject = simplexml_load_string($xmlString );    
                    return $result =json_decode(json_encode($xmlObject)); 
                }
                
            }else{
                return false;
            }
        }
        return false;
        
    }
}
