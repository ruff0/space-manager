<?php

namespace Mosaiqo\Cqrs\Contracts;

interface EventStore {
    /**
     * @param DomainEvent $event
     * @return mixed
     */
    public function append(DomainEvent $event);

    /**
     * @param $eventId
     * @return mixed
     */
    public function allStoredEventsSince($eventId);
}