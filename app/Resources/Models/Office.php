<?php

namespace App\Resources\Models;

class Office extends AbstractResource
{
	/**
	 * The corresponding table.
	 *
	 * @var string
	 */
	protected $table = 'offices';

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
