<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeWarrantyExternal extends Model
{
    use  SoftDeletes;
    protected $table="home_warranty_external";
    protected $guarded = [];

     public function agent_detail()
     {
         return $this->hasOne('App\User', 'HRMSID', 'hrms_id');
     }

    public function user(){
        return $this->belongsTo('App\User', 'hrms_id','HRMSID');
    }

	public function client(){
        return $this->belongsTo('App\Models\Client', 'client_code','client_code');
    }
 public function campaign(){
        return $this->belongsTo('App\Models\Campaign');
    }
    public function project(){
        return $this->belongsTo('App\Models\Project', 'project_code','project_code');
    }
}
