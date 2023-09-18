<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use SoftDeletes;
    protected $dates = [ 'deleted_at' ];
    protected $guarded = [];

    public function campaign(){
        return $this->belongsTo('App\Models\Campaign', 'campaign_id','id');
    }
    public function projects(){
        return $this->hasMany('App\Models\Project', 'client_id','id');
    }

}
