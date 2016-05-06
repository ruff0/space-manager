<?php

namespace App\Space;

use App\Resources\Models\Resource;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
	protected $table = 'subscriptions';

	protected $fillable = ['date_from', 'date_to'];

	protected $dates = ['date_from', 'date_to'];

	/**
	 * Get all of the owning bookable models.
	 */
	public function plan()
	{
		return $this->belongsTo(Plan::class);
	}

	/**
	 * Get all of the owning bookable models.
	 */
	public function resource()
	{
		return $this->belongsTo(Resource::class);
	}

	/**
	 * Get all of the owning member models.
	 */
	public function member()
	{
		return $this->belongsTo(Member::class);
	}
}
