<?php

namespace App\Space;

use App\Bookables\Bookable;
use Illuminate\Database\Eloquent\Model;

class Pass extends Model
{
	/**
	 * @var array
	 */
	protected $fillable = ['hours', 'date_to', 'bookable_id'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function member()
	{
		return $this->belongsTo(Member::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function bookable()
	{
		return $this->belongsTo(Bookable::class);
	}
}
