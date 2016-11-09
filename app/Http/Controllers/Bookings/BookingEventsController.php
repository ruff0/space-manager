<?php

namespace App\Http\Controllers\Bookings;

use App\Bookings\Booking;
use App\Events\EloquentEvent;
use App\Events\Models\Event;
use Illuminate\Contracts\Validation\UnauthorizedException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BookingEventsController extends Controller
{
    public function create(Booking $booking, Request $request)
    {
        if ($booking->member_id != $request->user()->member_id) {
            throw new UnauthorizedException();
        }

        if ($event = EloquentEvent::existsForBooking($booking)) {
            return redirect()->route("events", ["id" => $event->id]);
        }

        return view('events.create', [
            'event' => new Event(),
            'booking' => $booking,
        ]);
    }
}
