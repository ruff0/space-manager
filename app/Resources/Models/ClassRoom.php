<?php

namespace App\Resources\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model implements SluggableInterface
{
	use SluggableTrait;

	/**
	 * The corresponding table.
	 *
	 * @var string
	 */
	protected $table = 'class_rooms';

	/**
	 * @var array
	 */
	protected $fillable = [
		'name',
		'slug',
		'description',
		'floor',
		'max_occupants',
		'active'
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

	/**
	 * Is this room already a resource
	 * @return mixed
	 */
	public function isResource()
	{
		return $this->resourceables()->first();		
	}

	/**
	 * Is this room already a resource
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
	 * Save a new model and return the instance.
	 *
	 * @param  array $attributes
	 *
	 * @return static
	 */
	public static function create(array $attributes = [])
	{
		$meetingroom = parent::create($attributes);

		if(isset($attributes['create_resource']) && $attributes['create_resource'])
		{
			$meetingroom->resourceables()->save(new Resource());
		}

		return $meetingroom;
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
		$meetingroom = parent::update($attributes, $options);

		if (isset($attributes['create_resource']) && $attributes['create_resource'] && !$this->isResource()) {
			$this->resourceables()->save(new Resource());
		}
		elseif (!$attributes['create_resource'] && $this->isResource()) {
			$this->resourceables()->delete($this->resource()->id);
		}

		return $meetingroom;
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
