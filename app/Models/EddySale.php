<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EddySale extends Model
{ 
    protected $table = 'eddy_sales';
    //protected $fillable = ['sale_date','hrms_id','agent_id','billable_hours','sap_id'];
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\Models\EddyUser', 'agent_id','agent_name');
    }
}
