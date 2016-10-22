<?php

namespace App\Events\Domain;


use Ramsey\Uuid\Uuid;

class EventId
{

	public $id;

	private function __construct()
	{
		$this->id = Uuid::uuid4()->toString();
	}

	public static function create()
	{
		return new static;
	}

	public static function fromString($string)
	{
		$eventId =  new static;
		$eventId->id = Uuid::fromString($string);

		return $eventId;
	}
}