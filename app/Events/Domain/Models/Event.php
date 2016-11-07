<?php

namespace App\Events\Domain\Models;

use App\Events\Domain\EventDescription;
use App\Events\Domain\EventId;
use App\Events\Domain\EventImage;
use App\Events\Domain\Events\EventDescriptionWasAdded;
use App\Events\Domain\Events\EventImageWasAdded;
use App\Events\Domain\Events\EventTitleWasAdded;
use App\Events\Domain\EventTitle;
use Mosaiqo\Cqrs\AggregateRoot;
use Mosaiqo\Cqrs\Contracts\EventStream;
use Mosaiqo\Cqrs\Contracts\AggregateIdentity;
use Mosaiqo\Cqrs\Contracts\EventSourcedAggregateRoot;
use App\Events\Domain\Events\EventWasCreatedFromBooking;
use App\Bookings\Contracts\Domain\Models\BookingInterface;

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
	 * @var EventTitle
	 */
	private $title;

	/**
	 * @var EventTitle
	 */
	private $image;

	/**
	 * @var EventDescription
	 */
	private $description;

	/**
	 * Event constructor.
	 * @param EventId $id
	 */
	protected function __construct(EventId $id)
	{
		$this->id = $id;
	}

	/**
	 * @param AggregateIdentity $aggregateIdentity
	 * @param BookingInterface $booking
	 * @return static
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public static function fromBooking(AggregateIdentity $aggregateIdentity, BookingInterface $booking)
	{
		$event = new Event($aggregateIdentity);
		$event->raise(new EventWasCreatedFromBooking($aggregateIdentity, $booking));

		return $event;
	}

	/**
	 * @param EventTitle $title
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public function addTitle(EventTitle $title)
	{
		$this->raise(new EventTitleWasAdded(EventId::fromString($this->id), $title));
	}

	/**
	 * @param EventDescription $description
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public function addDescription(EventDescription $description)
	{
		$this->raise(new EventDescriptionWasAdded(EventId::fromString($this->id), $description));
	}

	/**
	 * @param EventImage $image
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public function addImage(EventImage $image)
	{
		$this->raise(new EventImageWasAdded(EventId::fromString($this->id), $image));
	}

	/**
	 * @param $event
	 * @throws \Exception
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	protected function apply($event)
	{
		$className = get_class($event);
		switch ($className){
			case EventWasCreatedFromBooking::class:
				$this->id = $event->id();
				$this->booking = $event->booking();
				break;

			case EventTitleWasAdded::class:
				$this->title = $event->title();
				break;

			case EventDescriptionWasAdded::class:
				$this->description = $event->description();
				break;

			case EventImageWasAdded::class:
				$this->image = $event->image();
				break;

			default :
				throw new \Exception("Event {$className} could not be applied.");
		}
	}


}