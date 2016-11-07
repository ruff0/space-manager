<?php

namespace Mosaiqo\Cqrs\Contracts;

interface EventStore {
	/**
	 * @param AggregateIdentity $aggregateIdentity
	 * @param DomainEvent $event
	 * @return mixed
	 */
    public function persist(AggregateIdentity $aggregateIdentity, DomainEvent $event);

    /**
     * @param $eventId
     * @return mixed
     */
    public function allStoredEventsSince($eventId);
}