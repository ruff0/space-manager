<?php

namespace App\Space;

use App\Files\Image;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;

class PlanType extends Model implements SluggableInterface
{
	use SluggableTrait;

	/**
	 * Fillable field to avoid mass assignment
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'show',
		'slug',
		'description',
		'active',
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

	#######################################################################################
	# Special Methods
	#######################################################################################
	/**
	 * Active plantypes
	 * @return mixed
	 */
	public function actives()
	{
		return $this->whereActive(true)->get();
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

	#######################################################################################
	# Relations
	#######################################################################################

	public function plans()
	{
		return $this->hasMany(Plan::class);
	}

	/**
	 * Get all of the tags for the post.
	 */
	public function images()
	{
		return $this->morphToMany(Image::class, 'imageable');
	}
}
