<?php

namespace App\Events\Domain\Events;


use App\Events\Domain\EventId;
use App\Events\Domain\EventImage;
use Carbon\Carbon;
use Mosaiqo\Cqrs\Contracts\DomainEvent;

class EventImageWasAdded implements DomainEvent
{

	/**
	 * @var EventId
	 */
	protected $id;

	/**
	 * @var EventImage
	 */
	protected $image;

	/**
	 * @var Carbon
	 */
	protected $occurredOn;


	/**
	 * EventImageWasAdded constructor.
	 * @param EventId $eventId
	 * @param EventImage $eventImage
	 */
	public function __construct(EventId $eventId, EventImage $eventImage)
	{
		$this->id = $eventId->toString();
		$this->image = $eventImage->toString();
		$this->occurredOn = Carbon::now();
	}

	/**
	 * @param array $payload
	 * @return EventImageWasAdded
	 * @author Boudy de Geer  <boudydegeer@mosaiqo.com>
	 */
	public static function fromArray(array $payload)
	{
		return new EventImageWasAdded(
			EventImage::fromString($payload['image'])
		);
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
	 * @return static
	 */
	public function occurredOn()
	{
		return $this->occurredOn;
	}

	/**
	 * @return string
	 * @author ${USER} <boudydegeer@mosaiqo.com>
	 */
	public function payload()
	{
		return json_encode([
			"image" => $this->image()
		]);
	}

	/**
	 * @return string
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public function image()
	{
		return $this->image;
	}
}