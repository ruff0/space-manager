<?php

namespace App\Events\Domain\Events;

use App\Bookings\Contracts\Domain\Models\BookingInterface;
use App\Bookings\Domain\Booking;
use App\Events\Domain\EventId;
use App\Events\Domain\Models\Event;
use Carbon\Carbon;
use Mosaiqo\Cqrs\Contracts\DomainEvent;

class EventWasCreatedFromBooking implements DomainEvent {

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

	/**
	 * @var Carbon
	 */
	protected $occurredOn;

	public function __construct(EventId $id, Event $event, BookingInterface $booking)
	{
		$this->id = $id;
		$this->event = $event;
		$this->booking = $booking;

		$this->occurredOn = Carbon::now();
	}

	/**
	 * @return static
	 */
	public function occurredOn(){
		return $this->occurredOn;
	}

	public function payload()
	{
		return json_encode([
			"event" => $this->event,
			"booking" => $this->booking
		]);
	}

	public static function fromArray(array $payload)
	{
		$booking  = new Booking;
		$eventId = EventId::fromString($payload['id']);

		return new EventWasCreatedFromBooking(
			$eventId,
			Event::fromBooking($eventId, $booking),
			$booking
		);
	}
}