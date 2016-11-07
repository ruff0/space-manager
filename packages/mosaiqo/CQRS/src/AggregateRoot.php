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
    public static function rebuildFrom($events)
    {
        $aggregate = new static;

        foreach ($events as $event) {
            $e = $event->type;
            $array = json_decode($event->payload, true);
            $array['id'] = $event->id;
            $aggregate->apply($e::fromArray($array));
        }

        return $aggregate;

    }

    /**
     * It applies the property based on the event.
     *
     * @param DomainEvent $event
     * @throws \Exception
     * @author Boudy de Geer <boudydegeer@mosaiqo.com>
     */
    protected function apply($event)
    {
        $className = (new \ReflectionClass($event))->getShortName();
        $method = "apply{$className}";


        if (method_exists($this, $method)) {
            return $this->$method($event);
        }

        if (!method_exists($this, 'apply')) {
            return $this->apply($event);
        } else {
            throw new \Exception("Your {$className} needs to have a method `apply`");
        }

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



