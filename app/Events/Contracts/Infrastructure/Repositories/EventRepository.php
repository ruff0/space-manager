<?php

namespace App\Events\Contracts\Infrastructure\Repositories;

interface EventRepository {

	public function save(Event $event);

	public function byId(EventId $eventId);
}