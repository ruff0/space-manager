<?php

namespace App\ValueObjects;

use Carbon\Carbon;

class Date {
	/**
	 * @var Carbon
	 */
	private $date;

	private function __construct(Carbon $date){
		$this->date = $date;
	}

	public static function fromString(string $string)
	{
		$date = Carbon::parse($string);
		return new self($date);
	}

	public function year()
	{
		return $this->date->year;
	}

	public function month()
	{
		return $this->date->month;
	}

	public function day()
	{
		return $this->date->day;
	}

	public function hour()
	{
		return $this->date->hour;
	}

	public function minute()
	{
		return $this->date->minute;
	}

	public function time()
	{
		return $this->date->format("H:i");
	}

	public function date()
	{
		return $this->date->format("d-m-Y");
	}

	public function isAfter(Date $date)
	{
		return $this->date->lt($date->date);
	}

	public function isBefore(Date $date)
	{
		return $this->date->gt($date->date);
	}

	public function differenceInHours(Date $date)
	{
		return $this->date->diffInHours($date->date);
	}


}