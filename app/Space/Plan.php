<?php

namespace App\Space;

use App\Events\Space\PlanWasCreated;
use App\Events\Space\PlanWasDeleted;
use App\Events\Space\PlanWasUpdated;
use App\Files\Image;
use App\Resources\Models\ClassRoom;
use App\Resources\Models\MeetingRoom;
use App\Resources\Models\Resource;
use App\Resources\Models\Spot;
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
		'discounts',
		'active',
		'standalone',
		'plan_type_id',
		'default'
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
	 * @var array
	 */
	protected $casts = [
		'discounts' => 'json'
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

	/**
	 * @return int
	 */
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
		self::cleanDefaults($attributes);

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
		self::cleanDefaults($attributes);

		$plan = parent::update($attributes, $options);
		// Extract this out of here
		if (isset($attributes['resources'])) {
			$resources = [];

			foreach ($attributes['resources'] as $key => $resource) {
				if (isset($resource['settings'])) {
					$resource['settings'] = json_encode($resource['settings']);
				}

				$resources[$key] = $resource;
			}
			$this->resources()->sync($resources);
		}


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

	#######################################################################################
	# Special Methods
	#######################################################################################
	public function hasType($type)
	{
		if ($type instanceof PlanType) {
			$type = $type->id;
		}

		if (is_integer($type)) {
			return $this->plan_type_id == $type;
		}

		return false;
	}

	/**
	 * Returns all active room resources.
	 * @return mixed
	 */
	public function roomResources()
	{
		return $this->resources()
		            ->ofType('room')->get();
	}


	/**
	 * @return string
	 */
	public function mainImage()
	{
		if ($this->images()->count() > 0) {
			return "/{$this->images()->first()->pathname}";
		}

		return "/images/placeholder.jpg";
	}

	/**
	 * @return mixed
	 */
	public static function byDefault()
	{
		$plan = new static;
		return $plan->where('default', true)->first();
	}
	#######################################################################################
	# Relations
	#######################################################################################
	/**
	 * Get all of the resources for the post.
	 */
	public function subscriptions()
	{
		return $this->hasMany(Subscription::class);
	}

	/**
	 * Get all of the resources for the post.
	 */
	public function resources()
	{
		return $this->morphToMany(Resource::class, 'resourceable')->withPivot('settings');
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function types()
	{
		return $this->belongsTo(PlanType::class, 'plan_type_id');
	}


	/**
	 * Get all of the tags for the post.
	 */
	public function images()
	{
		return $this->morphToMany(Image::class, 'imageable');
	}

	/**
	 * @param $attributes
	 */
	protected static function cleanDefaults(&$attributes)
	{
		if (isset($attributes['default']) && $attributes['default'] && $attributes['active']) {
			foreach (parent::all() as $plan) {
				$plan->default = false;
				$plan->save();
			}

			$attributes['default'] = true;
		}
	}
}
