<?php

namespace App\Resources\Models;

class ClassRoom extends AbstractResource
{
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
}
