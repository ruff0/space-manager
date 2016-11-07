<?php

namespace Mosaiqo\Cqrs\Contracts;

interface EventSubscriber {

	public function handle(DomainEvent $event);

	public function isSubscribedTo(DomainEvent $event);
}