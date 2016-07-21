<?php

namespace App\Resources\Models;

class Spot extends AbstractResource
{
	/**
	 * The corresponding table.
	 *
	 * @var string
	 */
	protected $table = 'spots';

	/**
	 * @var array
	 */
	protected $fillable = [
		'name',
		'slug',
		'description',
		'active'
	];
}
