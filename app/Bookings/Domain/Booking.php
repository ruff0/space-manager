<?php

namespace App\Bookings\Domain;

use App\Bookings\Contracts\Domain\Models\BookingInterface;

class Booking implements BookingInterface {

    public $id;

    public static function fromArray(array $array)
    {
        $booking = new Booking;
        $booking->id = $array['id'];
        $booking->member = $array['member_id'];
        $booking->resource = $array['resource_id'];
        $booking->distribution = $array['distribution'];
        $booking->persons = $array['persons'];
        $booking->date = $array['time_from'];
        $booking->timeFrom = $array['time_from'];
        $booking->timeTo = $array['time_to'];

        return $booking;
    }
}

