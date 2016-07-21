<?php

namespace App\Files;

use App\Bookables\Bookable;
use App\Bookables\BookableType;
use App\Files\Scopes\ImageScope;
use App\Space\Plan;
use App\Space\PlanType;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
	/**
	 * @var string
	 */
	protected $table = 'files';

	/**
	 * @var array
	 */
	protected $fillable = [
		'name',
		'path',
		'type',
		'extension',
		'pathname',
		'size'
	];

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope(new ImageScope);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function bookables()
	{
		return $this->morphedByMany(Bookable::class, 'imageable');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function bookabletypes()
	{
		return $this->morphedByMany(BookableType::class, 'imageable');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function plans()
	{
		return $this->morphedByMany(Plan::class, 'imageable');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function plantypes()
	{
		return $this->morphedByMany(PlanType::class, 'imageable');
	}
}
