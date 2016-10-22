<?php

namespace App\Events\Domain\Models;

use App\Bookings\Contracts\Domain\Models\BookingInterface;
use App\Events\Domain\EventId;
use App\Events\Domain\Events\EventWasCreatedFromBooking;
use App\ValueObjects\Date;
use Mosaiqo\Cqrs\AggregateRoot;
use Mosaiqo\Cqrs\Contracts\EventSourcedAggregateRoot;
use Mosaiqo\Cqrs\Contracts\EventStream;

class Event extends AggregateRoot implements EventSourcedAggregateRoot {

	/**
	 * @var
	 */
	public $booking;

	/**
	 * @var EventId
	 */
	public $id;


	private function __construct(EventId $id) {
		$this->id = $id;
	}

	/**
	 * @param BookingInterface $booking
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 * @return static
	 */
	public static function fromBooking(BookingInterface $booking)
	{
		$id = EventId::create();
		$event = new static($id);

		$event->process(
			new EventWasCreatedFromBooking($id, $event, $booking)
		);

		return $event;
	}

	/**
	 * @param $event
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	protected function applyEventWasCreatedFromBooking($event)
	{
		$this->id = $event->id;
		$this->booking = $event->booking;
	}

	/**
	 * @param $id
	 * @param $events
	 * @return Event
	 */
	public static function replay($id ,$events)
	{
		$aggregate = new self($id);

		foreach ($events as $event)
		{
			$aggregate->apply($event);
		}

		return $aggregate;

	}
}