<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class ProjectCode extends Model
{

    
    public $fillable = ['id','title','parent_id','code'];


    /**
     * Get the index name for the model.
     *
     * @return string
    */
    public function childs() {
        return $this->hasMany('App\Models\ProjectCode','parent_id','id') ;
    }
}