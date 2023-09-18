<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use SoftDeletes;
    protected $dates = [ 'deleted_at' ];
    protected $fillable = [
        'name'
    ];

    public function clients(){
        return $this->hasMany('App\Models\Client', 'campaign_id','id');
    }
}
