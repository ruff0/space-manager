<?php

namespace App\Events\Commands;

use App\Bookings\Domain\Booking;
use App\Events\Domain\Models\Event;
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

		  Event::fromBooking(new Booking());

	}
}