<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KbCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'img', 'description'
    ];	

    /**
	 * Get the author of the post.
	 */
	public function sub_categories()
	{
	    return $this->hasMany('App\Models\KbSubCategory', 'category_id');
	}

    public function getSlugAttribute()
    {
        return \Str::slug($this->name, '-');
    }

}
