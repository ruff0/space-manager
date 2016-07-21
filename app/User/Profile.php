<?php

namespace App\User;

use App\User\User;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property string  name
 * @property string  lastname
 */
class Profile extends Model
{
	protected $fillable = [
		'name',
		'lastname',
		'mobile',
	];

	/**
	 * Returns users profile fullname
	 *
	 * @return string
	 */
	public function fullName()
	{
		return $this->name . ' ' . $this->lastname;
	}

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
