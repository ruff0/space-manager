<?php

namespace App\Events\Domain\Models;

class Ticket
{
	private $price = 0;

	private $amount;

	/**
	 * FreeTicket constructor.
	 * @param $price
	 * @param $amount
	 */
	protected function __construct($price, $amount)
	{
		$this->price = $price;
		$this->amount = $amount;
	}

	/**
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 * @param $amount
	 * @param $price
	 * @return Ticket
	 */
	public static function generate($amount, $price)
	{
		return new Ticket($amount, $price);
	}

		/**
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 * @param $amount
	 * @return Ticket
	 */
	public static function generateFreeTicket($amount)
	{
		return new Ticket($amount, 0);
	}

	public function price()
	{
		return $this->price;
	}


	public function amount()
	{
		return $this->amount;
	}


}