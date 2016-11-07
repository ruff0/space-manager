<?php

namespace App\Events\Domain;


class EventTitle
{
	/**
	 * @var Uuid
	 */
	private $title;

	/**
	 * EventId constructor.
	 * @param string $string
	 */
	private function __construct(string $string)
	{
		$this->title = $string;
	}

	/**
	 * @param $string
	 * @return EventId
	 */
	public static function fromString(string $string)
	{
		return new EventTitle($string);
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		return $this->title;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->toString();
	}
}