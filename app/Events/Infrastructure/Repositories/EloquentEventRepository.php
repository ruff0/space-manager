<?php

namespace App\Events\Infrastructure\Repositories;

use App\Events\Contracts\Infrastructure\Repositories\Event;
use App\Events\Contracts\Infrastructure\Repositories\EventId;
use App\Events\Contracts\Infrastructure\Repositories\EventRepository;

class EloquentEventRepositories implements EventRepository
{
	private $eventStore;
	private $projector;

	public function __construct($eventStore, $projector = null)
	{
		$this->eventStore = $eventStore;
		$this->projector = $projector;
	}

	public function save(Event $event)
	{
		$events = $event->recorderdEvents();
		$this->eventStore->append(new EventStream($event->id()), $events);

		$event->clearEvents();
		if ($this->projector) {
			$this->projector->project($events);
		}
	}

	public function byId(EventId $eventId)
	{
		// TODO: Implement byId() method.
	}
}