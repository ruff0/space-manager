<?php

namespace App\Events\Commands;

use App\Bookings\Booking as EloquentBooking;
use App\Bookings\Domain\Booking;
use App\Events\Domain\EventDescription;
use App\Events\Domain\EventId;
use App\Events\Domain\EventImage;
use App\Events\Domain\EventTitle;
use App\Events\Domain\Models\Event;
use App\Files\File as EloquentFile;
use Illuminate\Support\Facades\File;
use Mosaiqo\Cqrs\EloquentEventStore;
use Symfony\Component\HttpFoundation\Request;

class CreateEventOrganizedByUser
{
	public static function fromRequest(Request $request)
	{
		$eventId = EventId::generateNew();
		$booking = EloquentBooking::find($request->get("booking"))->toArray();

		$file = EloquentFile::find($request->get('image'));

		if(File::exists("{$file->pathname}")) {
			File::move("{$file->pathname}", "images/events/{$eventId}.{$file->extension}");
			$file->pathname = "images/events/{$eventId}.{$file->extension}";
			$file->save();
		}

		$event = Event::fromBooking($eventId, Booking::fromArray($booking));
		$event->addTitle(EventTitle::fromString($request->get('title')));
		$event->addDescription(EventDescription::fromString($request->get('description')));
		$event->addImage(EventImage::fromFile($file));

		EloquentEventStore::persistAllFor($eventId, collect($event->pendingEvents()));
	}
}