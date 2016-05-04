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
 * @property mixed bookable_type_id
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
		if ($type instanceof BookableType)
			$type = $type->id;

		if(is_integer($type))
			return $this->bookable_type_id == $type;

		return false;
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


	public function roomResources()
	{
		return $this->resources()
		             ->whereIn('resources.resourceable_type', [
			             MeetingRoom::class,  ClassRoom::class,  Spot::class
		             ])->get();
	}


	/**
	 * Update the model in the database.
	 *
	 * @param  array $attributes
	 * @param  array $options                                       ñ
	 *
	 * @return bool|int
	 */
	public function update(array $attributes = [], array $options = [])
	{
		$bookable = parent::update($attributes, $options);
		// Extract this out of here
		if (isset($attributes['resources'])) {
			$resources = [];

			foreach ($attributes['resources'] as $key => $resource)
			{
				if (isset($resource['settings'])) {
				  $resource['settings'] = json_encode($resource['settings']);
				}

				$resources[$key] = $resource;
			}
			$this->resources()->sync($resources);
		}

		return $bookable;
	}

}
