<?php

namespace App\Resources\Models;

class MeetingRoom extends AbstractResource
{

	/**
	 * The corresponding table.
	 *
	 * @var string
	 */
	protected $table = 'meeting_rooms';

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
