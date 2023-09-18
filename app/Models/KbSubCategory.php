<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KbSubCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'category_id'
    ];	

    /**
	 * Get the author of the post.
	 */
	public function category()
	{
	    return $this->belongsTo('App\Models\KbCategory');
	}

    /**
     * Get the author of the post.
     */
    public function articles()
    {
        return $this->hasMany('App\Models\KnowledgeBase', 'sub_category_id');
    }

    public function getSlugAttribute()
    {
        return \Str::slug($this->name, '-');
    }
}
