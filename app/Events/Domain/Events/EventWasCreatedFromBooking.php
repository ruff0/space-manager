<?php

namespace App\Events\Domain\Events;

use App\Bookings\Contracts\Domain\Models\BookingInterface;
use App\Events\Domain\EventId;
use App\Events\Domain\Models\Event;
use Mosaiqo\Cqrs\Contracts\DomainEventInterface;

class EventWasCreatedFromBooking implements DomainEventInterface {

		/**
	 * @var EventId
	 */
	public $id;

		/**
	 * @var Event
	 */
	public $event;

	/**
	 * @var BookingInterface
	 */
	public $booking;

	public function __construct(EventId $id, Event $event, BookingInterface $booking)
	{
		$this->id = $id;
		$this->event = $event;
		$this->booking = $booking;
	}
}