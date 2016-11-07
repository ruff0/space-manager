<?php

namespace App\Events\Domain\Events;


use App\Events\Domain\EventId;
use App\Events\Domain\EventTitle;
use Carbon\Carbon;
use Mosaiqo\Cqrs\Contracts\DomainEvent;

class EventTitleWasAdded implements DomainEvent {

	/**
	 * @var EventId
	 */
	protected $id;

		/**
	 * @var EventTitle
	 */
	protected $title;

	/**
	 * @var Carbon
	 */
	protected $occurredOn;


	/**
	 * EventTitleWasAdded constructor.
	 * @param EventId $eventId
	 * @param EventTitle $eventTitle
	 */
	public function __construct(EventId $eventId, EventTitle $eventTitle)
	{
		$this->id = $eventId->toString();
		$this->title = $eventTitle->toString();
		$this->occurredOn = Carbon::now();
	}

	/**
	 * @return EventId
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public function id()
	{
		return $this->id;
	}

	/**
	 * @return EventTitle
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public function title()
	{
		return $this->title;
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
			"title" => $this->title()
		]);
	}

	/**
	 * @param array $payload
	 * @return EventWasCreatedFromBooking
	 * @author Boudy de Geer  <boudydegeer@mosaiqo.com>
	 */
	public static function fromArray(array $payload)
	{
		return new EventTitleWasAdded(
			EventTitle::fromString($payload['title'])
		);
	}
}