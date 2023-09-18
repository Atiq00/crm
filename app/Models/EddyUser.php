<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class EddyUser extends Model
{
    protected $table = 'eddy_users';
    //protected $fillable = ['sale_date','hrms_id','agent_id','billable_hours','sap_id'];
    protected $guarded = [];
}
