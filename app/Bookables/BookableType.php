<?php

namespace App\Bookables;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;

class BookableType extends Model implements SluggableInterface
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
		'description',
		'active',
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
	public function actives()
	{
		return $this->whereActive(true)->get();
	}

	#######################################################################################
	# Relations
	#######################################################################################

	public function bookables()
	{
		return $this->hasMany(Bookable::class);
	}
}
