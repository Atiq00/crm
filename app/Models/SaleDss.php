<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDss extends Model
{
    //
     protected $guarded =[];
     public function user(){
        return $this->belongsTo('App\User', 'user_id','HRMSID');
    }

     protected $fillable = [
        'record_id',
        'customer_no',
        'first_name',
        'last_name',
        'address',
        'city',
        'state',
        'zipcode',
        'phone',
        'email',
        'area',
        'question_1',
        'question_2',
        'question_3',
        'question_4',
        'question_3_1',
        'question_3_2',
        'others_question_1',
        'others_question_2',
        'customer_name',
        'comments',
        'promo_code',
        'user_id',
        'campaign_id',
        'client_code',
        'project_code',

     ];
    //  public function client(){
    //     return $this->belongsTo('App\Models\Client', 'client_code','client_code');
    // }

    // public function campaign(){
    //     return $this->belongsTo('App\Models\Campaign', 'campaign_id','id');
    // }
    // public function project(){
    //     return $this->belongsTo('App\Models\Project', 'project_code','project_code');
    // }
}
