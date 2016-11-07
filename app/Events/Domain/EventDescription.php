<?php

namespace App\Events\Domain;


class EventDescription
{
	/**
	 * @var Description
	 */
	private $description;

	/**
	 * EventId constructor.
	 * @param string $string
	 */
	private function __construct($string)
	{
		$this->description = $string;
	}

	/**
	 * @param $string
	 * @return EventId
	 */
	public static function fromString($string)
	{
		return new EventDescription($string);
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		return $this->description;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->toString();
	}
}