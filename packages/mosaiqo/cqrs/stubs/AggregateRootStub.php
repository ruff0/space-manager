<?php

namespace Mosaiqo\Cqrs\Stubs;

use Mosaiqo\Cqrs\AggregateRoot;
use Mosaiqo\Cqrs\Contracts\DomainEvent;

class AggregateRootStub extends AggregateRoot
{

	public function process(DomainEvent $event)
	{
		parent::process($event);
	}

	public function apply(DomainEvent $event)
	{
		parent::apply($event);
	}

	public function publish(DomainEvent $event)
	{
		parent::publish($event);
	}

	public function record(DomainEvent $event)
	{
		parent::record($event);
	}

	public function applyDomainEventStub(DomainEvent $event)
	{

	}

}