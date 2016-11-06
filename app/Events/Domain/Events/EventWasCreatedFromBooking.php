<?php

namespace App\Events\Domain\Events;

use Carbon\Carbon;
use App\Events\Domain\EventId;
use App\Bookings\Domain\Booking;
use App\Events\Domain\Models\Event;
use Mosaiqo\Cqrs\Contracts\DomainEvent;
use App\Bookings\Contracts\Domain\Models\BookingInterface;

class EventWasCreatedFromBooking implements DomainEvent {

		/**
	 * @var EventId
	 */
	protected $id;

	/**
	 * @var BookingInterface
	 */
	protected $booking;

	/**
	 * @var Carbon
	 */
	protected $occurredOn;

	/**
	 * EventWasCreatedFromBooking constructor.
	 * @param EventId $eventId
	 * @param BookingInterface $booking
	 */
	public function __construct(EventId $eventId, BookingInterface $booking)
	{
		$this->id = $eventId->toString();
		$this->booking = $booking;

		$this->occurredOn = Carbon::now();
	}

	/**
	 * @return EventId
	 * @author ${USER} <boudydegeer@mosaiqo.com>
	 */
	public function id()
	{
		return $this->id;
	}

	/**
	 * @return BookingInterface
	 * @author ${USER} <boudydegeer@mosaiqo.com>
	 */
	public function booking()
	{
		return $this->booking;
	}

	/**
	 * @return static
	 */
	public function occurredOn(){
		return $this->occurredOn;
	}

	/**
	 * @return string
	 * @author ${USER} <boudydegeer@mosaiqo.com>
	 */
	public function payload()
	{
		return json_encode([
			"booking" => $this->booking()
		]);
	}

	/**
	 * @param array $payload
	 * @return EventWasCreatedFromBooking
	 * @author Boudy de Geer  <boudydegeer@mosaiqo.com>
	 */
	public static function fromArray(array $payload)
	{
		return new EventWasCreatedFromBooking(
			EventId::fromString($payload['id']),
			Booking::fromArray($payload['booking'])
		);
	}
}