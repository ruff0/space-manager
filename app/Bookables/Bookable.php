<?php

namespace App\Bookables;

use App\Bookings\Booking;
use App\Files\Image;
use App\Resources\Models\ClassRoom;
use App\Resources\Models\MeetingRoom;
use App\Resources\Models\Resource;
use App\Resources\Models\Spot;
use App\Space\Pass;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;

/**
 * @property mixed  bookable_type_id
 * @property string times
 * @property string totalPrice
 * @property string message
 * @property mixed  images
 * @property float  discount
 * @property mixed  raw_price
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

		if($this->resources->first())
		{
			return $this->resources->first()->getPrice();
		}

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
				$bookable->available = true;
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
	 * @param $available
	 * @param $timeFrom
	 * @param $timeTo
	 */
	public function scopeAvailableWithIn($query, $hours, $available, $timeFrom, $timeTo)
	{
		return $query->getWithHours($hours, $available, $timeFrom, $timeTo);
	}

	/**
	 * @param $available
	 */
	public function scopeNotAvailableWithIn($query, $available)
	{
		$bookables = $query->whereNotIn('id', $available)->get();

		foreach ( $bookables as $bookable )
		{
			$bookable->available = false;
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
		$this->times = $timeFrom->format('H:i') . " - " . $timeTo->format('H:i') . " (" . $hours . " Horas)";
		$this->totalPrice = $this->calculatePriceForTimeFrame($hours, $timeFrom, $timeTo) . ' €';
		$this->raw_price = $this->calculatePriceForTimeFrame($hours, $timeFrom, $timeTo, true);
		$this->message = $this->messageForTimeFrame($hours, $timeFrom, $timeTo);
		$this->discount = $this->calculateIfDiscount($this->totalPrice);
	}


	/**
	 * @param      $hours
	 * @param      $timeFrom
	 * @param      $timeTo
	 * @param bool $clean
	 *
	 * @return mixed
	 */
	public function calculatePriceForTimeFrame($hours, $timeFrom, $timeTo,  $clean = false)
	{
		$totalPrice = 0;

		if ($this->isPartTime($hours, $timeFrom, $timeTo)) {
			$totalPrice = $this->pricePartTime($clean);
		}

		if ($hours >= 6) {
			$totalPrice = $this->priceFullTime($clean);
		}

		if ($totalPrice <= 0) {
			$totalPrice = $this->pricePerHour($clean) * $hours;
		}

		return $totalPrice;
	}

	/**
	 * @param $hours
	 *
	 * @param $timeFrom
	 * @param $timeTo
	 *
	 * @return string
	 */
	public function messageForTimeFrame($hours, $timeFrom, $timeTo)
	{
		$message = "";

		if ($this->isPartTime($hours, $timeFrom, $timeTo) && $this->pricePartTime(true) > 0) {
			$message = "* Precio de media jornada";
		}

		if ($hours >= 6 && $this->priceFullTime(true)> 0) {
			$message = "* Precio de jornada completa";
		}

		return $message;
	}



	/**
	 * @return string
	 */
	public function mainImage()
	{
		if ($this->images()->count() > 0) {
			return "/{$this->images()->first()->pathname}";
		}

		return "/images/placeholder.jpg";
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
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function passes()
	{
		return $this->belongsTo(Pass::class);
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

	/**
	 * @param $hours
	 * @param $timeFrom
	 * @param $timeTo
	 *
	 * @return bool
	 */
	public function isPartTime($hours, $timeFrom, $timeTo)
	{
		$limitFrom = Carbon::create($timeFrom->year, $timeFrom->month, $timeFrom->day, 15, 01, 0);
		$limitTo = Carbon::create($timeFrom->year, $timeFrom->month, $timeFrom->day, 15, 59, 0);

		if($hours >= 4 &&
		   !$limitFrom->between($timeFrom, $timeTo, false) &&
		   !$limitTo->between($timeFrom, $timeTo, false)
		) {
			return true;
		}

		return false;
	}

	/**
	 * @param $totalPrice
	 *
	 * @return float
	 */
	private function calculateIfDiscount($totalPrice)
	{
		$discount = auth()->user()->member->hasDiscount('bookings');
		$discountPrice = 0;
		$percentage = 0;
		$message = "";

		if($discount)
		{
			$discountPrice = $totalPrice - (($totalPrice / 100) * $discount['percentage']);
			$percentage = $discount['percentage'];
			$message = "Se te aplica un {$percentage}% de descuento";
		}

		return [
			'message' => $message,
			'percentage' => $percentage,
			'price' => $discountPrice . ' €'
		];
	}


}
