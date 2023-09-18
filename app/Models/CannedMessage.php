<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CannedMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'message', 'public', 'user_id'
    ];

    /**
	 * Get the author of the post.
	 */
	public function user()
	{
	    return $this->belongsTo('App\User');
	}
}
