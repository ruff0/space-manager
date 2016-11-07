<?php

namespace Mosaiqo\Cqrs;

use Illuminate\Support\Collection;;
use Illuminate\Support\Facades\DB;
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
	 * @param AggregateIdentity $aggregateIdentity
	 * @param Collection $events
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 *
	 * @return mixed|void
	 */
	public static function persistAllFor(AggregateIdentity $aggregateIdentity, Collection $events)
	{
		$store = new EloquentEventStore();
		DB::beginTransaction();
		$events->each(function ($event) use ($store, $aggregateIdentity) {
			$store->persist($aggregateIdentity, $event);
		});
		DB::commit();

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