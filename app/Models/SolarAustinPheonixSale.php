<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SolarAustinPheonixSale extends Model
{
    use SoftDeletes;
    protected $table = 'solar_pci'; 
    protected $guarded = [];

    // public function user(){
    //     return $this->belongsTo('App\User', 'user_id','HRMSID');
    // }

    // public function client(){
    //     return $this->belongsTo('App\Models\Client', 'client_code','client_code');
    // }

    // public function campaign(){
    //     return $this->belongsTo('App\Models\Campaign', 'campaign_id','id');
    // }
    // public function project(){
    //     return $this->belongsTo('App\Models\Project', 'project_code','project_code');
    // }

    public function scopeSearch($austin_phoenix,$search,$start_date,$end_date,$client_id,$project_id,$user_id,$reporting_to=null){       
         
        if($search){        
            $austin_phoenix =$austin_phoenix->where(function($query)use($search){
                $query->where('phone_number','LIKE',"%".@$search."%");
                $query->orWhere('last_name','LIKE',"%".@$search."%");            
                $query->orWhere('first_name','LIKE',"%".@$search."%");            
                $query->orWhere('type','LIKE',"%".@$search."%");            
            });
        }
        if($client_id){
            $austin_phoenix = $austin_phoenix->where('client_code',$client_id);
        }
        if($client_id){
            $austin_phoenix = $austin_phoenix->where('client_code',$client_id);
        }
        if($project_id){
            $austin_phoenix = $austin_phoenix->where('project_code',$project_id);
        }
        if($user_id){
            $austin_phoenix = $austin_phoenix->where('user_id',$user_id);
        }
        if($start_date && $end_date){
            $austin_phoenix = $austin_phoenix->whereDate('created_at',">=",$start_date)->whereDate('created_at',"<=",$end_date);
        } 
        if($reporting_to){
            $users = \DB::table('users')->where('reporting_to_id',$reporting_to)->pluck('HRMSID');
            $austin_phoenix = $austin_phoenix->whereIn('user_id',$users);
        }
        return $austin_phoenix;
    }
}
