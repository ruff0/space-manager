<?php

namespace App\Events\Domain\Events;


use App\Events\Domain\EventId;
use App\Events\Domain\Models\Ticket;
use App\Events\Domain\TicketId;
use Carbon\Carbon;
use Mosaiqo\Cqrs\Contracts\DomainEvent;

class TicketWasGeneratedForEvent implements DomainEvent {

	/**
	 * @var EventId
	 */
	protected $id;

		/**
	 * @var Ticket
	 */
	protected $ticket;

	/**
	 * @var Carbon
	 */
	protected $occurredOn;


	/**
	 * TicketWasGeneratedForEvent constructor.
	 * @param EventId $eventId
	 * @param Ticket $ticket
	 */
	public function __construct(EventId $eventId, Ticket $ticket)
	{
		$this->id = $eventId->toString();
		$this->ticket = $ticket;
		$this->occurredOn = Carbon::now();
	}

	/**
	 * @return EventId
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public function id()
	{
		return $this->id;
	}

	/**
	 * @return Ticket
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public function ticket()
	{
		return $this->ticket;
	}


	/**
	 * @return static
	 */
	public function occurredOn(){
		return $this->occurredOn;
	}

	/**
	 * @return string
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public function payload()
	{
		return json_encode([
			"price" => $this->ticket()->amount(),
			"amount" => $this->ticket()->price()
		]);
	}

	/**
	 * @param array $payload
	 * @return EventWasCreatedFromBooking
	 * @author Boudy de Geer  <boudydegeer@mosaiqo.com>
	 */
	public static function fromArray(array $payload)
	{
//		return new TicketWasGeneratedForEvent(
//			EventTitle::fromString($payload['title'])
//		);
	}
}