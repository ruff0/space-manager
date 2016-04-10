<?php

namespace App\Space;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string  name
 * @property integer price
 */
class Plan extends Model
{
	/**
	 * The corresponding table.
	 *
	 * @var string
	 */
	protected $table = 'plans';

	/**
	 * The fillable field to avoid mass assignment
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'price',
		'description',
	];

	/**
	 * Multiplies price by 100 to have clean integers to work with
	 *
	 * @param $value
	 */
	public function setPriceAttribute($value)
	{
		$this->attributes['price'] = $value * 100;
	}


	/**
	 * Divides price by 100 to get the real price
	 *
	 * @param $value
	 *
	 * @return float
	 */
	public function getPriceAttribute($value)
	{
		return $value / 100;
	}
}
