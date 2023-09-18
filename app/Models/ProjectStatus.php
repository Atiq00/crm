<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProjectStatus extends Model
{
    use SoftDeletes;
    protected $table="project_inactive_users";
    protected $guarded =[];

}
