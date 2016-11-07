<?php

namespace Mosaiqo\Cqrs;

use Mosaiqo\Cqrs\Contracts\DomainEvent;
use Mosaiqo\Cqrs\Contracts\EventStore;
use Mosaiqo\Cqrs\Contracts\EventSubscriber;

class PersistEventSubscriber implements EventSubscriber  {

	private $eventStore;

	public function __construct(EventStore $eventStore)
	{
		$this->eventStore = $eventStore;
	}

	public function handle(DomainEvent $event)
	{
		$this->eventStore->append($event);
	}

	public function isSubscribedTo(DomainEvent $event)
	{
		return true;
	}
}