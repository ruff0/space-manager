<?php

namespace Mosaiqo\Cqrs;

use Mosaiqo\Cqrs\Contracts\DomainEvent;
use Mosaiqo\Cqrs\Contracts\EventSubscriber;

class DomainEventPublisher
{
	private $subscribers;
	private static $instance = null;

	/**
	 * @return DomainEventPublisher
	 */
	public static function instance()
	{
		if(null === static::$instance)
		{
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct()
	{
		$this->subscribers = [];
	}

	public function __clone()
	{
		throw new \BadMethodCallException("Clone is not supported");
	}

	public function subscribe(EventSubscriber $subscriber)
	{
		$this->subscribers[] = $subscriber;
	}

	public function publish(DomainEvent $event)
	{

		foreach ($this->subscribers as $subscriber)
		{
			if($subscriber->isSubscribedTo($event))
			{
				$subscriber->handle($event);
			}
		}
	}
}