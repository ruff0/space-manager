<?php

namespace App\User;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 */
class Profile extends Model
{
	protected $fillable = [
		'name',
		'lastname',
		'identity',
		'address_line1',
		'city',
		'state',
		'zip',
		'mobile',
		'phone',

	];

	/**
	 * Returns the related user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
