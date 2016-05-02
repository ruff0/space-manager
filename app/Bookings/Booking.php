<?php

namespace App\Bookings;

use App\Bookables\Bookable;
use App\Resources\Models\Resource;
use App\Space\Member;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
	protected $table = 'bookings';

	protected $fillable = ['time_from', 'time_to'];
	
	protected $dates = ['time_from', 'time_to'];

	/**
	 * Get all of the owning bookable models.
	 */
	public function bookable()
	{
		return $this->belongsTo(Bookable::class);
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
