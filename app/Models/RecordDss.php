<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordDss extends Model
{
    //
    protected $guarded =[];
    protected $table = "record_dsses";

    public function dssdatafile()
    {
        return $this->hasOne(DssDataFile::class,'dssdatafile_id' ,'id');
    }
}
