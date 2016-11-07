<?php

namespace App\Events\Domain;


use Mosaiqo\Cqrs\Contracts\AggregateIdentity;
use Ramsey\Uuid\Uuid;

class EventId implements AggregateIdentity
{
	/**
	 * @var Uuid
	 */
	private $id;

	/**
	 * EventId constructor.
	 * @param Uuid $id
	 */
	private function __construct(Uuid $id)
	{
		$this->id = $id;
	}

	/**
	 * @return static
	 */
	public static function create()
	{
		return new static;
	}

	/**
	 * @param $string
	 * @return EventId
	 */
	public static function fromString($string)
	{
		return new EventId(Uuid::fromString($string));

	}

	/**
	 * @return EventId
	 */
	public static function generateNew()
	{
		return new EventId(Uuid::uuid4());
	}

	/**
	 * @param AggregateIdentity $that
	 * @return bool
	 */
	public function equals(AggregateIdentity $that)
	{
		return $this->id == $that->id;
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		return $this->id->toString();
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->toString();
	}
}