<?php

namespace App\Events\Domain\Models;

class Ticket
{
    private $price = 000;

    private $amount;

    /**
     * FreeTicket constructor.
     * @param $price
     * @param $amount
     */
    protected function __construct($amount, $price)
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
        return new Ticket($amount, 000);
    }

    /**
     * @return int
     */
    public function price()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function amount()
    {
        return $this->amount;
    }


}