<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use SoftDeletes;
    protected $dates = [ 'deleted_at' ];
    protected $fillable = ['name','project_code','client_id','hours','seats','pro_real_name'];

    public function client(){
        return $this->belongsTo('App\Models\Client', 'client_id','id');
    }

    public function projects(){
        return $this->hasMany('App\Models\Client', 'campaign_id','id');
    }
     
}
