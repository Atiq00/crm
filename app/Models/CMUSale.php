<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CMUSale extends Model
{
    use SoftDeletes;
    protected $table = 'cmu_sales';
    protected $guarded = [];
    public function project(){
        return $this->belongsTo('App\Models\Project', 'project_code','project_code');
    }
    public function user(){
        return $this->belongsTo('App\Models\LatestUsers', 'project_code','project_code');
    }
}
