<?php

namespace App\Bookables;

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
		return $this->hasOne(BookableType::class);
	}

}
