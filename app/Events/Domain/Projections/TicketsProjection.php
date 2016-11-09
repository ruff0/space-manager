<?php

namespace App\Events\Domain\Projections;

use App\Events\Domain\Events\EventDescriptionWasAdded;
use App\Events\Domain\Events\EventImageWasAdded;
use App\Events\Domain\Events\EventTitleWasAdded;
use App\Events\Domain\Events\EventWasCreatedFromBooking;
use App\Events\Domain\Events\TicketWasGeneratedForEvent;
use App\Events\EloquentEvent;
use App\Events\EloquentTicket;
use Carbon\Carbon;
use Mosaiqo\Cqrs\Contracts\DomainEvent;
use Mosaiqo\Cqrs\Contracts\EventSubscriber;

class TicketsProjection implements EventSubscriber
{

    public function handle(DomainEvent $event)
    {
        switch (get_class($event)) {
            case TicketWasGeneratedForEvent::class:
                $projection = new EloquentTicket;
                $projection->amount = $event->ticket()->amount();
                $projection->available = $event->ticket()->amount();
                $projection->price = $event->ticket()->price();
                $projection->event_id = $event->id();
                $projection->save();
                break;

            default:
                return false;
        }
    }

    public function isSubscribedTo(DomainEvent $event)
    {
        switch (get_class($event)) {
            case TicketWasGeneratedForEvent::class :
                return true;
                break;

            default:
                return false;
        }
    }
}