<?php

namespace App\Bookables;

use App\Files\Image;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;

class BookableType extends Model implements SluggableInterface
{
	use SluggableTrait;

	/**
	 * Fillable field to avoid mass assignment
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
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
	public function actives()
	{
		return $this->whereActive(true)->get();
	}

	/**
	 * @param int $hours
	 *
	 * @return int
	 */
	public function pricePerHour($hours = 1)
	{
		$this->pricePerHour = $hours * 50;
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

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function bookables()
	{
		return $this->hasMany(Bookable::class);
	}

	/**
	 * Get all of the tags for the post.
	 */
	public function images()
	{
		return $this->morphToMany(Image::class, 'imageable');
	}
}
