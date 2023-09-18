<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
	 * Get the author of the post.
	 */
	public function faqs()
	{
	    return $this->hasMany('App\Models\Faq', 'category_id');
	}



}
