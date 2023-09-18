<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Project;
class User extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = [
        //'name', 'email', 'password', 'image','HRMSID','reporting_to_id',"type",'pseudo_name','designation'
    //];
protected $guarded = [];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $dates = [ 'deleted_at' ];

    public function sendPasswordResetNotification($token)
    {
        // Your your own implementation.
        $this->notify(new ResetPasswordNotification($token, 'admin'));
    }
    public function projects(){
        return $this->belongsToMany(Project::class,'client_projects','user_id','project_id');
    }
    public function reportingtoname()
     {
        return $this->hasOne('App\User','HRMSID','reporting_to_id');
    }
    public function reporting()
    {
        return $this->hasOne('App\User','HRMSID','reporting_to_id');
    }

 


}
