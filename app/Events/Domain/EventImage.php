<?php

namespace App\Events\Domain;


use App\Files\File;

class EventImage
{
	/**
	 * @var Uuid
	 */
	private $image;

	/**
	 * EventId constructor.
	 * @param string $string
	 */
	private function __construct($string)
	{
		$this->image = $string;
	}

	/**
	 * @param $string
	 * @return EventId
	 */
	public static function fromString($string)
	{
		return new EventImage($string);
	}

	/**
	 * @param File $file
	 * @return EventImage
	 */
	public static function fromFile(File $file)
	{
		return new EventImage($file->pathname);
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		return $this->image;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->toString();
	}
}