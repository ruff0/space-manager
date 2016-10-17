<?php

namespace Mosaiqo\Cqrs\Contracts;

/**
 * EventSourcedAggregateRoot
 * @author boudydegeer <boudydegeer@mosaiqo.com>
 */
interface EventSourcedAggregateRoot
{
	public static function reconstitute(EventStream $events);
}


