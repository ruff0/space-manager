<?php

namespace App\Events\Domain\Projections;

use App\Events\Domain\Events\EventDescriptionWasAdded;
use App\Events\Domain\Events\EventImageWasAdded;
use App\Events\Domain\Events\EventTitleWasAdded;
use App\Events\Domain\Events\EventWasCreatedFromBooking;
use App\Events\Domain\Events\TicketWasGeneratedForEvent;
use App\Events\EloquentEvent;
use Carbon\Carbon;
use Mosaiqo\Cqrs\Contracts\DomainEvent;
use Mosaiqo\Cqrs\Contracts\EventSubscriber;

class EventListProjection implements EventSubscriber
{

    public function handle(DomainEvent $event)
    {
        switch (get_class($event)) {
            case EventWasCreatedFromBooking::class:
                $booking = $event->booking();
                $projection = new EloquentEvent;
                $projection->id = $event->id();
                $projection->date = Carbon::parse($booking->date);
                $projection->from = Carbon::parse($booking->timeFrom);
                $projection->to = Carbon::parse($booking->timeTo);
                $projection->booking_id = $booking->id;
                $projection->resource_id = $booking->resource;
                $projection->member_id = $booking->member;
                $projection->distribution = $booking->distribution;
                $projection->persons = $booking->persons;
                $projection->save();
                break;

            case EventTitleWasAdded::class:
                $projection = EloquentEvent::find($event->id());
                $projection->title = $event->title();
                $projection->save();
                break;

            case EventImageWasAdded::class:
                $projection = EloquentEvent::find($event->id());
                $projection->image = $event->image();
                $projection->save();
                break;

            case EventDescriptionWasAdded::class:
                $projection = EloquentEvent::find($event->id());
                $projection->description = $event->description();
                $projection->save();
                break;

            default:
                return false;
        }
    }

    public function isSubscribedTo(DomainEvent $event)
    {
        switch (get_class($event)) {
            case EventWasCreatedFromBooking::class :
            case EventTitleWasAdded::class :
            case EventDescriptionWasAdded::class :
            case EventImageWasAdded::class :
                return true;
                break;

            default:
                return false;
        }
    }
}