<?php

namespace Mosaiqo\Cqrs;

use Mosaiqo\Cqrs\Contracts\AggregateIdentity;
use Mosaiqo\Cqrs\Contracts\DomainEvent;
use Mosaiqo\Cqrs\Contracts\EventStore;

class EloquentEventStore implements EventStore
{

	/**
	 * @param AggregateIdentity $aggregateIdentity
	 * @param DomainEvent $event
	 * @return mixed
	 */
	public function persist(AggregateIdentity $aggregateIdentity, DomainEvent $event)
	{
		$storedEvent = new EloquentStoredEvent([
			'id' => $aggregateIdentity,
			'type' => get_class($event),
			'payload' => $event->payload(),
			'occurredAt' => $event->occurredOn(),
		]);

		$storedEvent->save();

    $eventPublisher = DomainEventPublisher::instance();
    $eventPublisher->publish($event);
	}

	/**
	 * @param $eventId
	 * @return mixed
	 */
	public function allStoredEventsSince($eventId)
	{
		return EloquentStoredEvent::where('id', "=", $eventId)->get();
	}
}