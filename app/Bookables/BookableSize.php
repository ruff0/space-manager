<?php

namespace App\Bookables;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;

class BookableSize extends Model implements SluggableInterface
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
}
