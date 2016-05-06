<?php

namespace App\Resources\Models;

use App\Bookables\Bookable;
use App\Bookings\Booking;
use App\Space\Plan;
use App\Space\Subscription;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{

	/**
	 * The accessors to append to the model's array form.
	 *
	 * @var array
	 */
	protected $appends = ['settings'];

	/**
	 * Hidden attributes
	 * @var array
	 */
	protected $hidden = ['pivot'];

	public function getSettingsAttribute($value)
	{
		return $this->fromJson( $this->pivot->settings);
	}

	/**
	 * Scope a query to only include resources of a given type.
	 *
	 * @param $query
	 * @param $type
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeOfType($query, $type)
	{
		switch ($type) {
			case "price" :
				$type = Price::class;
				break;
			case "classroom" :
				$type = ClassRoom::class;
				break;
			case "spot" :
				$type = Spot::class;
				break;
			case "meetingroom" :
				$type = MeetingRoom::class;
				break;

			case "room" :
				return $query->whereIn('resources.resourceable_type', [
					MeetingRoom::class, ClassRoom::class, Spot::class
				]);
				break;
		}

		return $query->where('resourceable_type', $type);
	}

	/**
	 * Scope a query for the not selected by certain model
	 *
	 * @param $query
	 * @param $resourceable
	 *
	 * @return mixed
	 */
	public function scopeNotSelectedBy($query, $resourceable)
	{
		return $query->whereNotIn('id', $resourceable->resources->lists('id'));
	}

	/**
	 * Get the results of certain type
	 *
	 * @param $type
	 *
	 * @return mixed
	 */
	public function getOfType($type)
	{
		return $this->ofType($type)->get();
	}

	/**
	 * Get all of the owning resourceable models.
	 *
	 * @return mixed
	 */
	public function resourceable()
	{
		return $this->morphTo();
	}

	/**
	 * Get all the plans that are assigned to this resource
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function plans()
	{
		return $this->morphedByMany(Plan::class, 'resourceable');
	}

	/**
	 * Get all the bookables that are assigned to this resource
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function bookables()
	{
		return $this->morphedByMany(Bookable::class, 'resourceable');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function bookings()
	{
		return $this->hasMany(Booking::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function subscriptions()
	{
		return $this->hasMany(Subscription::class);
	}

}
