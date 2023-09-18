<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Project;
class HeadCount extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = [
        //'name', 'email', 'password', 'image','HRMSID','reporting_to_id',"type",'pseudo_name','designation'
    //];
    protected $guarded = []; 
    protected $table = "latest_users"; 
 
    public function reportings()
    {
        return $this->hasMany('App\HeadCount','reporting_to_id','HRMSID'); 
    }

    public function childrens()
    {
        return $this->hasMany('App\HeadCount','reporting_to_id','HRMSID')->with('childrens');
    }
 

 


}
