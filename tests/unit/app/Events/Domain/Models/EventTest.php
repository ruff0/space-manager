<?php

use App\Bookings\Contracts\Domain\Models\BookingInterface;
use App\Events\Domain\EventId;
use App\Events\Domain\Models\Event;
use App\ValueObjects\Date;

class EventTest extends TestCase {

	/**
	 * @test
	 */
	public function it_creates_an_event_from_a_booking()
	{

		$booking = \Mockery::mock(BookingInterface::class);

    $eventId = EventId::generateNew();
		$event = Event::fromBooking($eventId, $booking);

		$this->assertInstanceOf(App\Events\Domain\Models\Event::class, $event);
		$this->assertInstanceOf(BookingInterface::class, $event->getBooking());
	}
}