<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question', 'answer', 'category_id'
    ];

    /**
	 * Get the author of the post.
	 */
	public function category()
	{
	    return $this->belongsTo('App\Models\FaqCategory');
	}
}
