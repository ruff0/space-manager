<?php

namespace Mosaiqo\Cqrs\Tests;

use Mockery as m;
use Mosaiqo\Cqrs\Stubs\DomainEventStub;
use Mosaiqo\Cqrs\Stubs\AggregateRootStub;

class AggregateRootTest extends TestCase {

	/**
	 * @test
	 */
	public function it_records_an_event()
	{
		$stub = new AggregateRootStub;
		$event = new DomainEventStub;
		$stub->record($event);

		$this->assertEquals([$event], $stub->recordedEvents());
	}

	/**
	 * @test
	 */
	public function it_clear_all_the_events()
	{
		$stub = new AggregateRootStub;
		$event = new DomainEventStub;
		$stub->record($event);

		$stub->clearEvents();

		$this->assertEquals([], $stub->recordedEvents());
	}
}