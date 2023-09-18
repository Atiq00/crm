<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'department_id', 'customer_id', 'user_id', 'status', 'status_reply', 'priority_id'
    ];

    /**
	 * Get the author of the post.
	 */
	public function customer()
	{
	    return $this->belongsTo('App\Models\Customer');
	}

    /**
	 * Get the author of the post.
	 */
	public function department()
	{
	    return $this->belongsTo('App\Models\Department');
	}

    /**
	 * Get the author of the post.
	 */
	public function priority()
	{
	    return $this->belongsTo('App\Models\Priority');
	}

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
	public function replies()
	{
	    return $this->hasMany('App\Models\TicketReply');
	}



}
