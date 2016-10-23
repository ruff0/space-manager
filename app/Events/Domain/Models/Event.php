<?php

namespace App\Events\Domain\Models;

use App\Bookings\Contracts\Domain\Models\BookingInterface;
use App\Events\Domain\EventId;
use App\Events\Domain\Events\EventWasCreatedFromBooking;
use Mosaiqo\Cqrs\AggregateRoot;
use Mosaiqo\Cqrs\Contracts\EventSourcedAggregateRoot;
use Mosaiqo\Cqrs\Contracts\EventStream;

class Event extends AggregateRoot implements EventSourcedAggregateRoot
{

	/**
	 * @var
	 */
	public $booking;

	/**
	 * @var EventId
	 */
	public $id;


	/**
	 * Event constructor.
	 */
	protected function __construct()
	{
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

		$event->publish(
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


}