<?php

namespace App\Team;

use App\User\User;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
	/**
	 * Fillable fields
	 */
	protected $fillable = [
		'name',
		'identity',
		'address_line1',
		'address_line2',
		'zip',
		'city',
		'state',
		'phone'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function users()
	{
		return $this->hasMany(User::class);
	}
}
