<?php

namespace App\Space;

use App\User\User;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
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
		'phone',
		'mobile',
		'company_name',
		'company_identity',
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function users()
	{
		return $this->hasMany(User::class);
	}
}
