<?php

namespace App\Events\Commands;

use App\Bookings\Booking as EloquentBooking;
use App\Bookings\Domain\Booking;
use App\Events\Domain\EventDescription;
use App\Events\Domain\EventId;
use App\Events\Domain\EventImage;
use App\Events\Domain\EventTitle;
use App\Events\Domain\Models\Event;
use App\Events\EloquentEvent;
use App\Files\File as EloquentFile;
use Illuminate\Support\Facades\File;
use Mosaiqo\Cqrs\EloquentEventStore;
use Symfony\Component\HttpFoundation\Request;

class ReserveTicketForUser
{
	public static function fromRequest(Request $request)
	{
		$eventId = EventId::fromString($request->json("event"));

		$event = Event::fromArray(
		    EloquentEvent::find($request->json("event"))->toArray()
    );

    $event->reserveFreeTicketsByUser($request->json("amount"), $request->user());
		EloquentEventStore::persistAllFor($eventId, collect($event->pendingEvents()));
	}
}