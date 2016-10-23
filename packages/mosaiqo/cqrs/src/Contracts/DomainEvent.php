<?php

namespace Mosaiqo\Cqrs\Contracts;

/**
 * DomainEvent
 * @author boudydegeer <boudydegeer@mosaiqo.com>
 */
interface DomainEvent {
	public function payload();
	public static function fromArray(array $payload);
}