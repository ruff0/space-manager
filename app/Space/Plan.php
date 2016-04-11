<?php

namespace App\Space;

use App\Events\Space\PlanWasCreated;
use App\Events\Space\PlanWasDeleted;
use App\Events\Space\PlanWasUpdated;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;


/**
 * @property string  name
 * @property integer price
 * @property string  slug
 * @property string  stripe_id
 */
class Plan extends Model implements SluggableInterface
{
	use SluggableTrait;

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
	 * Sluggable field build array
	 *
	 * @var array
	 */
	protected $sluggable = [
		'build_from' => 'name',
		'save_to'    => 'slug',
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

	public function priceForStripe()
	{
		return $this->price * 100;
	}

	/**
	 * Save a new model and return the instance.
	 *
	 * @param  array $attributes
	 *
	 * @return static
	 */
	public static function create(array $attributes = [])
	{
		$plan = parent::create($attributes);

		list($stripePlan) = event(
			new PlanWasCreated($plan)
		);
		$plan->stripe_id = $stripePlan->id;
		$plan->save();

		return $plan;
	}


	/**
	 * Update the model in the database.
	 *
	 * @param  array $attributes
	 * @param  array $options
	 *
	 * @return bool|int
	 */
	public function update(array $attributes = [], array $options = [])
	{
		$plan = parent::update($attributes, $options);

		if($plan)
		{
			list($stripePlan) = event(
				new PlanWasUpdated($this)
			);
		}

		return $plan;
	}

	/**
	 * Delete the model from the database.
	 *
	 * @return bool|null
	 *
	 * @throws \Exception
	 */
	public function delete()
	{
		$deleted = parent::delete();

		if($deleted)
		{
			list($stripePlan) = event(
				new PlanWasDeleted($this)
			);
		}

		return $deleted;
	}
}
