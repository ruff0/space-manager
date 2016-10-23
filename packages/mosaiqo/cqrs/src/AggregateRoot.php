<?php

namespace Mosaiqo\Cqrs;

use Mosaiqo\Cqrs\Contracts\DomainEvent;

class AggregateRoot
{

	/**
	 * @var array
	 */
	protected $pendingEvents = [];

	/**
	 * AggregateRoot constructor.
	 */
	protected function __construct()
	{
	}

	/**
	 * @param $events
	 * @return Event
	 */
	public static function rebuildFrom(DomainEvent $events)
	{
		$aggregate = new self;

		foreach ($events as $event) {
			$aggregate->apply($event);
		}

		return $aggregate;

	}

	/**
	 * It applies the property based on the event.
	 *
	 * @param DomainEvent $event
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	protected function apply(DomainEvent $event)
	{
		event();
		$className = (new \ReflectionClass($event))->getShortName();
		$method = "apply{$className}";
		$this->$method($event);
	}

	/**
	 * Returns a collection of all events still to apply
	 * @return array
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public function pendingEvents()
	{
		$events = $this->pendingEvents;
		$this->clearEvents();
		return $events;
	}

	/**
	 * Clear the events collection.
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public function clearEvents()
	{
		$this->pendingEvents = [];
	}

	/**
	 * It records a Domain event to a collection
	 * @param DomainEvent $event
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	protected function raise(DomainEvent $event)
	{
		$this->pendingEvents[] = $event;
		$this->apply($event);
	}
}



