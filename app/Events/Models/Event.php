<?php

namespace App\Events\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	/**
	 * @var string
	 */
	protected $table = 'events';

	/**
	 * @var array
	 */
	protected $appends = ['isNew'];

	/**
	 * @return bool
	 */
	public function getIsNewAttribute()
	{
		return !$this->exists;
	}
}
