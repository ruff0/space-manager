<?php

namespace App\Resources\Models;

use App\Bookables\Bookable;
use App\Bookings\Booking;
use App\Files\Image;
use App\Space\Plan;
use App\Space\Subscription;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['settings'];

    /**
     * Hidden attributes
     * @var array
     */
    protected $hidden = ['pivot'];

    /**
     * @param $value
     *
     * @return mixed
     */
    public function getSettingsAttribute($value)
    {
        return $this->fromJson($this->pivot->settings, true);
    }

    /**
     * @param $value
     *
     * @return mixed
     * @throws \Exception
     */
    public function settings($value = null)
    {
        if (!$this->pivot) {
            return null;
        }

        $settings = $this->fromJson($this->pivot->settings, true);

        if ($value && property_exists($settings, $value)) {
            return $settings->$value;
        }

        if ($value && !property_exists($settings, $value)) {
            return [];
        }


        return $settings;
    }


    /**
     * Scope a query to only include resources of a given type.
     *
     * @param $query
     * @param $type
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        switch ($type) {
            case "price" :
                $type = Price::class;
                break;
            case "classroom" :
                $type = ClassRoom::class;
                break;
            case "spot" :
                $type = Spot::class;
                break;
            case "virtual" :
                $type = Virtual::class;
                break;
            case "meetingroom" :
                $type = MeetingRoom::class;
                break;
            case "office" :
                $type = Office::class;
                break;

            case "room" :
                return $query->whereIn('resources.resourceable_type', [
                    "App\\Resources\\Models\\MeetingRoom",
                    "App\\Resources\\Models\\ClassRoom",
                    "App\\Resources\\Models\\Spot",
                    "App\\Resources\\Models\\Virtual",
                    "App\\Resources\\Models\\Office",
                ]);
                break;
        }

        return $query->where('resourceable_type', $type);
    }

    /**
     * Scope a query for the not selected by certain model
     *
     * @param $query
     * @param $resourceable
     *
     * @return mixed
     */
    public function scopeNotSelectedBy($query, $resourceable)
    {
        return $query->whereNotIn('id', $resourceable->resources->lists('id'));
    }

    /**
     * Get the results of certain type
     *
     * @param $type
     *
     * @return mixed
     */
    public function getOfType($type)
    {
        return $this->ofType($type)->get();
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
        return $this->getPrice();
    }

    /**
     * @param string $type
     *
     * @return mixed
     */
    public function getPrice($type = 'hourly')
    {
        switch ($type) {
            case 'part_time' :
                $price = $this->settings->price->part_time;
                break;
            case 'full_time' :
                $price = $this->settings->price->full_time;
                break;
            default:
                $price = $this->settings->price->hourly;
                break;
        }

        return $price / 100;
    }

    /**
     * @return int
     */
    public function priceForStripe($type = 'hourly')
    {
        return $this->getPrice($type) * 100;
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
     * Get all of the owning resourceable models.
     *
     * @return mixed
     */
    public function resourceable()
    {
        return $this->morphTo();
    }

    /**
     * Get all the plans that are assigned to this resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function plans()
    {
        return $this->morphedByMany(Plan::class, 'resourceable');
    }

    /**
     * Get all the bookables that are assigned to this resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function bookables()
    {
        return $this->morphedByMany(Bookable::class, 'resourceable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }


    /**
     * Get all of the tags for the post.
     */
    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }

    public function isEventable()
    {
        return (bool) $this->settings('eventable');
    }

}
