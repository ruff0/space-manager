<?php

namespace App\Resources\Models;

class Virtual extends AbstractResource
{
	/**
	 * The corresponding table.
	 *
	 * @var string
	 */
	protected $table = 'virtuals';


	/**
	 * Has infinite resources
	 * @var bool
	 */
	protected $infinite = true;

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
