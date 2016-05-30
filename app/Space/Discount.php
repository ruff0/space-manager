<?php

namespace App\Space;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
	/**
	 * @var string
	 */
	protected $table = 'discounts';

	/**
	 * @var array
	 */
	protected $fillable = [
		'percentage',
		'type',
		'date_from',
		'date_to'
	];

	/**
	 * @var array
	 */
	protected $dates = ['date_from', 'date_to'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function member()
	{
		return $this->belongsTo(Member::class);
	}
}
