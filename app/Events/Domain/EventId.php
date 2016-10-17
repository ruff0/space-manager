<?php

namespace App\Events\Domain;


use Ramsey\Uuid\Uuid;

class EventId
{

	public $id;

	private function __construct()
	{
		$this->id = Uuid::uuid4();
	}

	public static function create()
	{
		return new static;
	}
}