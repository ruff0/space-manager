<?php

namespace App\Events\Domain\Models;

use App\Bookings\Contracts\Domain\Models\BookingInterface;
use App\Events\Domain\EventId;
use App\Events\Domain\Events\EventWasCreatedFromBooking;
use Mosaiqo\Cqrs\AggregateRoot;
use Mosaiqo\Cqrs\Contracts\AggregateIdentity;
use Mosaiqo\Cqrs\Contracts\EventSourcedAggregateRoot;
use Mosaiqo\Cqrs\Contracts\EventStream;

class Event extends AggregateRoot implements EventSourcedAggregateRoot
{

	/**
	 * @var
	 */
	private $booking;

	/**
	 * @var EventId
	 */
	private $id;


	/**
	 * Event constructor.
	 */
	protected function __construct()
	{
	}

	/**
	 * @param AggregateIdentity $aggregateIdentity
	 * @param BookingInterface $booking
	 * @return static
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public static function fromBooking(AggregateIdentity $aggregateIdentity, BookingInterface $booking)
	{
		$event = new Event;
		$event->raise(new EventWasCreatedFromBooking($aggregateIdentity, $event, $booking));

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