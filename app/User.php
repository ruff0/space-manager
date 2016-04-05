<?php

namespace App;

use App\User\Profile;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property mixed profile
 * @property mixed id
 */
class User extends Authenticatable
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * Return the user avatar
	 *
	 * @param int $size Size for the avatar image
	 *
	 * @return string
	 */
	public function avatar($size = 40)
	{
		return "http://www.gravatar.com/avatar/" . md5(strtolower(trim($this->email))) . "?s=" . $size;
	}

	/**
	 * Whether the user has a profile already set or not
	 */
	public function hasProfile()
	{
		return $this->profile;
	}

	/**
	 * The user profile
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function profile()
	{
		return $this->hasOne(Profile::class);
	}

	/**
	 * The team this user belongs to
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function team()
	{
		return $this->belongsTo(User::class);
	}
}
