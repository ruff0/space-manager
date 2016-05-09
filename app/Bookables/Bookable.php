<?php

namespace App\Bookables;

use App\Bookings\Booking;
use App\Files\Image;
use App\Resources\Models\ClassRoom;
use App\Resources\Models\MeetingRoom;
use App\Resources\Models\Resource;
use App\Resources\Models\Spot;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;

/**
 * @property mixed  bookable_type_id
 * @property string times
 * @property string totalPrice
 * @property string message
 */
class Bookable extends Model implements SluggableInterface
{
	use SluggableTrait;

	/**
	 * Fillable field to avoid mass assignment
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'slug',
		'bookable_type_id',
		'description',
		'max_occupants',
		'active',
		'floor',
	];

	/**
	 * Sluggable field build array
	 *
	 * @var array
	 */
	protected $sluggable = [
		'build_from' => 'name',
		'save_to'    => 'slug',
	];

	#######################################################################################
	# Special Methods
	#######################################################################################
	public function hasType($type)
	{
		if ($type instanceof BookableType) {
			$type = $type->id;
		}

		if (is_integer($type)) {
			return $this->bookable_type_id == $type;
		}

		return false;
	}

	/**
	 * @return mixed
	 */
	public function pricePerHour($clean = false)
	{
		if ($clean) {
			return $this->resources->first()->priceForStripe();
		}

		return $this->resources->first()->getPrice();
	}

	/**
	 * @return mixed
	 */
	public function pricePartTime($clean = false)
	{
		if ($clean) {
			return $this->resources->first()->priceForStripe('part_time');
		}

		return $this->resources->first()->getPrice('part_time');
	}

	/**
	 * @return mixed
	 */
	public function priceFullTime($clean = false)
	{
		if ($clean) {
			return $this->resources->first()->priceForStripe('full_time');
		}

		return $this->resources->first()->getPrice('full_time');
	}


	/**
	 * @param $query
	 * @param $hours
	 * @param $available
	 * @param $timeFrom
	 * @param $timeTo
	 *
	 * @return mixed
	 */
	public function scopeGetWithHours($query, $hours, $available, $timeFrom, $timeTo)
	{
		$bookables = $query->whereIn('id', $available)->get();

		foreach ($bookables as $bookable) {
			if ($bookable->resources) {
				$bookable->time_to = $timeTo->format('H:i');
				$bookable->time_from = $timeFrom->format('H:i');
				$bookable->hours = $hours;
				$bookable->calculatePrice($hours, $timeFrom, $timeTo);
			}
		}

		return $bookables;
	}

	/**
	 * @param $hours
	 * @param $timeFrom
	 * @param $timeTo
	 */
	public function calculatePrice($hours, $timeFrom, $timeTo)
	{
		$this->times = $timeTo->format('H:i') . " - " . $timeFrom->format('H:i') . " (" . $hours . " Horas)";
		$this->message = $this->messageForTimeFrame($hours);
		$this->totalPrice = $this->calculatePriceForTimeFrame($hours) . ' €';
	}


	/**
	 * @param      $hours
	 * @param bool $clean
	 *
	 * @return mixed
	 */
	public function calculatePriceForTimeFrame($hours, $clean = false)
	{
		$totalPrice = $this->pricePerHour($clean) * $hours;

		if ($hours >= 4) {
			$totalPrice = $this->pricePartTime($clean);
		}

		if ($hours >= 6) {
			$totalPrice = $this->priceFullTime($clean);
		}

		return $totalPrice;
	}

	/**
	 * @param      $hours
	 *
	 * @return string
	 */
	public function messageForTimeFrame($hours)
	{
		$message = "";

		if ($hours >= 4) {
			$message = "* Precio de media jornada";
		}

		if ($hours >= 6) {
			$message = "* Precio de jornada completa";
		}

		return $message;
	}

	#######################################################################################
	# Relations
	#######################################################################################	

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function types()
	{
		return $this->belongsTo(BookableType::class, 'bookable_type_id');
	}


	/**
	 * Get all of the resources for the post.
	 */
	public function resources()
	{
		return $this->morphToMany(Resource::class, 'resourceable')->withPivot('settings');
	}

	/**
	 * Get all of the tags for the post.
	 */
	public function images()
	{
		return $this->morphToMany(Image::class, 'imageable');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function bookings()
	{
		return $this->hasMany(Booking::class);
	}


	/**
	 * @return mixed
	 */
	public function roomResources()
	{
		return $this->resources()
		            ->whereIn('resources.resourceable_type', [
			            MeetingRoom::class,
			            ClassRoom::class,
			            Spot::class
		            ])->get();
	}


	/**
	 * Update the model in the database.
	 *
	 * @param  array $attributes
	 * @param  array $options ñ
	 *
	 * @return bool|int
	 */
	public function update(array $attributes = [], array $options = [])
	{
		$bookable = parent::update($attributes, $options);
		// Extract this out of here
		if (isset($attributes['resources'])) {
			$resources = [];

			foreach ($attributes['resources'] as $key => $resource) {
				if (isset($resource['settings'])) {
					// Set the prices to be integers always
					if (isset($resource['settings']['price'])) {
						foreach ($resource['settings']['price'] as $priceType => $value) {
							$resource['settings']['price'][$priceType] = $value * 100;
						}
					}


					$resource['settings'] = json_encode($resource['settings']);

				}

				$resources[$key] = $resource;
			}
			$this->resources()->sync($resources);
		}

		return $bookable;
	}


}
