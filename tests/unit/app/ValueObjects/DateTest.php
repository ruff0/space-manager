<?php

use App\ValueObjects\Date;

class DateTest extends TestCase {
	/**
	 * @test
	 */
	public function it_creates_a_date_from_a_string()
	{
		$date = Date::fromString("2016-01-01 16:00");

		$this->assertInstanceOf(App\ValueObjects\Date::class, $date);
		$this->assertEquals(2016, $date->year());
		$this->assertEquals(01, $date->month());
		$this->assertEquals(01, $date->day());
		$this->assertEquals(16, $date->hour());
		$this->assertEquals(00, $date->minute());
		$this->assertEquals("16:00", $date->time());
		$this->assertEquals("01-01-2016", $date->date());
	}

	/**
	 * @test
	 */
	public function it_compares_two_dates_if_its_after()
	{
		$date = Date::fromString("2016-01-01 16:00");
		$dateAfter = Date::fromString("2016-01-01 19:00");

		$this->assertTrue($date->isAfter($dateAfter));
		$this->assertFalse($date->isBefore($dateAfter));
	}

	/**
	 * @test
	 */
	public function it_compares_two_dates_if_its_before()
	{
		$date = Date::fromString("2016-01-01 16:00");
		$dateBefore = Date::fromString("2016-01-01 11:00");

		$this->assertFalse($date->isAfter($dateBefore));
		$this->assertTrue($date->isBefore($dateBefore));
	}

}