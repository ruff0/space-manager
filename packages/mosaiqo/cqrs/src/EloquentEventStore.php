<?php

namespace Mosaiqo\Cqrs;

use Mosaiqo\Cqrs\Contracts\DomainEvent;
use Mosaiqo\Cqrs\Contracts\EventStore;

class EloquentEventStore implements EventStore
{

	/**
	 * @param DomainEvent $event
	 * @return mixed
	 */
	public function append(DomainEvent $event)
	{
		$storedEvent = new EloquentStoredEvent([
			'id' => $event->id,
			'type' => get_class($event),
			'occurredAt' => $event->occurredOn(),
			'payload' => $event->toJson()
		]);

		$storedEvent->save();
	}

	/**
	 * @param $eventId
	 * @return mixed
	 */
	public function allStoredEventsSince($eventId)
	{
		$storedEvent = EloquentStoredEvent::where('id', "=", $eventId)->get();

		$storedEvent->map(function($event){
			 new $event->type()
		});
	}
}