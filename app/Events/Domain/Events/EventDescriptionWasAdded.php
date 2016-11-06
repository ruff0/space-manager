<?php

namespace App\Events\Domain\Events;


use Carbon\Carbon;
use Mosaiqo\Cqrs\Contracts\DomainEvent;
use App\Events\Domain\EventDescription;

class EventDescriptionWasAdded implements DomainEvent {

		/**
	 * @var EventId
	 */
	protected $description;

	/**
	 * @var Carbon
	 */
	protected $occurredOn;


	/**
	 * EventDescriptionWasAdded constructor.
	 * @param EventDescription $eventDescription
	 */
	public function __construct(EventDescription $eventDescription)
	{
		$this->description = $eventDescription->toString();
		$this->occurredOn = Carbon::now();
	}

	/**
	 * @return string
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public function description()
	{
		return $this->description;
	}

	/**
	 * @return Carbon|static
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public function occurredOn(){
		return $this->occurredOn;
	}

	/**
	 * @return string
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public function payload()
	{
		return json_encode([
			"description" => $this->description()
		]);
	}

	/**
	 * @param array $payload
	 * @return EventDescriptionWasAdded
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public static function fromArray(array $payload)
	{
		return new EventDescriptionWasAdded(
			EventDescription::fromString($payload['description'])
		);
	}
}