<?php

namespace Mosaiqo\Cqrs\Contracts;

interface AggregateIdentity {
	public static function fromString($id);
	public static function generateNew();
	public function equals(AggregateIdentity $that);
	public function toString();
}