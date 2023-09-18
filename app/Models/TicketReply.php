<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
	protected $casts = [
        'attachments' => 'array',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ticket_id', 'message', 'attachments', 'user_id'
    ];

    /**
	 * Get the author of the post.
	 */
	public function user()
	{
	    return $this->belongsTo('App\User');
	}

    /**
	 * Get the author of the post.
	 */
	public function customer()
	{
	    return $this->belongsTo('App\Models\Customer');
	}
}
