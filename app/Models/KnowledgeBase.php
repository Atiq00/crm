<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeBase extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'category_id', 'sub_category_id', 'active'
    ];

    /**
     * Get the author of the post.
     */
    public function sub_category()
    {
        return $this->belongsTo('App\Models\KbSubCategory');
    }

    /**
     * Get the author of the post.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\KbCategory');
    }

    public function getSlugAttribute()
    {
        return \Str::slug($this->title, '-');
    }
}
