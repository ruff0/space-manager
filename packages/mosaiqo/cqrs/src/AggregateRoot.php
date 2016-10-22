<?php

namespace Mosaiqo\Cqrs;

use Mosaiqo\Cqrs\Contracts\DomainEvent;

class AggregateRoot {

	protected $recordedEvents = [];

	/**
	 * Processes a DomainEvent
	 *
	 * @param DomainEvent $event
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	protected function process(DomainEvent $event)
	{
		$this->record($event);
		$this->apply($event);
		$this->publish($event);
	}

	/**
	 * It records a Domain event to a collection
	 * @param DomainEvent $event
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	protected function record(DomainEvent $event)
	{
		$this->recordedEvents[] = $event;
	}

	/**
	 * It applies the property based on the event.
	 *
	 * @param DomainEvent $event
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	protected function apply(DomainEvent $event)
	{
		$className = (new \ReflectionClass($event))->getShortName();
		$method = "apply{$className}";
		$this->$method($event);
	}

	/**
	 * Publishes a DomainEvent
	 * @param DomainEvent $event
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	protected function publish(DomainEvent $event)
	{
		// Perhaps we want to pass it in the constructor?
		$eventPublisher = DomainEventPublisher::instance();
		$eventPublisher->publish($event);
	}

	/**
	 * Returns a collection of events
	 * @return array
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public function recordedEvents()
	{
		return $this->recordedEvents;
	}

	/**
	 * Clear the events collection.
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public function clearEvents()
	{
		$this->recordedEvents = [];
	}
}



