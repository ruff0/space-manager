<?php

namespace App\User;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
	/**
	 * Fillable fields
	 */
	protected $fillable = ['company_name', 'company_id'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function users()
	{
		return $this->hasMany(User::class);
	}
}
