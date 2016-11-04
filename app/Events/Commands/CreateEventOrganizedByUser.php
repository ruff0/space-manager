<?php

namespace App\Events\Commands;

use App\Bookings\Domain\Booking;
use App\Events\Domain\EventId;
use App\Events\Domain\Models\Event;
use Mosaiqo\Cqrs\Contracts\EventStore;
use Mosaiqo\Cqrs\EloquentEventStore;
use Symfony\Component\HttpFoundation\Request;

class CreateEventOrganizedByUser
{
	public static function fromRequest(Request $request)
	{
//		$title = EventTitle::fromString($request->get("title"));
//		$description = EventDescription::fromString($request->get("description"));
//		$image = EventImage::fromString($request->get("image"));
//		$date  = EventDate::fromString($request->get("date"));
//		$timeFrom = Time::fromString($request->get("time")["from"]);
//		$timeTo = Time::fromString($request->get("time")["to"]);
//
//		$timeSpan = TimeSpan::create($timeFrom, $timeTo);
//
//		$event = Event::startsAt($timeFrom);
//		$event->endsAt($timeTo);
//		$event->addTitle($title);
//		$event->addDescription($description);
//		$event->addImage($image);
//
//		foreach($request->get("tickets") as $ticketFromRequest)
//		{
//			$ticket = Ticket::fromPrice($ticketFromRequest['price']);
//			$ticket->availability($ticketFromRequest["quantity"]);
//
//			$event->addTickets($ticket);
//		}
		$eventId = EventId::generateNew();

    $booking = \App\Bookings\Booking::find($request->get("booking"))->toArray();
		$event = Event::fromBooking($eventId, Booking::fromArray($booking));

		$eventStore = new EloquentEventStore();
		foreach ($event->pendingEvents() as $pendingEvent)
		{
			$eventStore->persist($eventId, $pendingEvent);
		}

	}
}