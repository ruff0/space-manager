<?php

namespace App\Events;

use App\Bookings\Booking;
use Illuminate\Database\Eloquent\Model;

class EloquentEvent extends Model
{

    protected $table = 'events';

    protected $fillable = ["*"];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $timestamps = false;

    protected $with = ['tickets'];

    public static function existsForBooking(Booking $booking)
    {
        return EloquentEvent::where("booking_id", $booking->id)->first();
    }

    public function tickets()
    {
        return $this->hasMany(EloquentTicket::class, 'event_id');
    }
}