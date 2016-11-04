<?php

namespace App\Bookings\Domain;

use App\Bookings\Contracts\Domain\Models\BookingInterface;

class Booking implements BookingInterface {

    public $id;

    public static function fromArray(array $array)
    {
        $booking = new Booking;
        $booking->id = $array['id'];

        return $booking;
    }
}

