<?php

namespace App\Resources\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
	/**
	 * Get all of the owning resourceable models.
	 * @return mixed
	 */
	public function resourceables()
	{
		return $this->mornphTo();
	}
}
