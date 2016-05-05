<?php

namespace App\Resources\Models;

use App\Bookings\Booking;
use App\Space\Subscription;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class AbstractResource extends Model implements SluggableInterface
{

	use SluggableTrait;

	/**
	 * Sluggable field build array
	 *
	 * @var array
	 */
	protected $sluggable = [
		'build_from' => 'name',
		'save_to'    => 'slug',
	];


	public $type = '';

	public $category = '';

	protected $cast = [
	'settings' => 'json'
	];
	/**
	 * Is this room already a resource
	 *
	 * @return mixed
	 */
	public function isResource()
	{
		return $this->resourceables()->first();
	}

	/**
	 * Is this room already a resource
	 *
	 * @return mixed
	 */
	public function resource()
	{
		return $this->resourceables()->first();
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function resourceables()
	{
		return $this->morphMany(Resource::class, 'resourceable');
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
		return $this->hasMany(Subscription::class, 'resource_id', 'id');
	}

	/**
	 * Save a new model and return the instance.
	 *
	 * @param  array $attributes
	 *
	 * @return static
	 */
	public static function create(array $attributes = [])
	{
		$resource = parent::create($attributes);

		if (isset($attributes['create_resource']) && $attributes['create_resource']) {
			$resource->resourceables()->save(new Resource());
		}

		return $resource;
	}


	/**
	 * Update the model in the database.
	 *
	 * @param  array $attributes
	 * @param  array $options
	 *
	 * @return bool|int
	 */
	public function update(array $attributes = [], array $options = [])
	{
		$resource = parent::update($attributes, $options);

		if (isset($attributes['create_resource']) && $attributes['create_resource'] && !$this->isResource()) {
			$this->resourceables()->save(new Resource());
		} elseif (!$attributes['create_resource'] && $this->isResource()) {
			$this->resourceables()->delete($this->resource()->id);
		}

		return $resource;
	}

	/**
	 * Delete the model from the database.
	 *
	 * @return bool|null
	 *
	 * @throws \Exception
	 */
	public function delete()
	{
		$deleted = parent::delete();

		if ($deleted && $this->isResource()) {
			$this->resourceables()->delete($this->resource()->id);
		}

		return $deleted;
	}
}
