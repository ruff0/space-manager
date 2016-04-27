<?php namespace App\Invoices;

use Illuminate\Contracts\Support\Jsonable;

class QuoteLine implements Jsonable{

	public $amount = 1;

	public $name;

	public $description;

	public $price = 0;

	protected $currency = "€";

	/**
	 * Line constructor.
	 *
	 * @param array $attributes
	 */
	public function __construct(array $attributes = [])
	{
		foreach ($attributes as $key => $value)
		{
			$this->$key = $value;
		}
	}

	/*
	 *
	 */
	public function priceFormatCurrency()
	{
		return number_format($this->price(), 2) . $this->currency;
	}

	/**
	 * @return mixed
	 */
	public function price()
	{
		return ($this->price / 100);
	}

	/**
	 * @param string $currency
	 *
	 * @return Line
	 */
	public function setCurrency($currency)
	{
		$this->currency = $currency;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCurrency()
	{
		return $this->currency;
	}

	/**
	 *
	 */
	public function totalPrice()
	{
		return number_format($this->price() * $this->amount,  2);
	}


	/**
	 *
	 */
	public function totalPriceFormatCurrency()
	{
		return number_format($this->price() * $this->amount, 2)  . $this->currency;
	}

	/**
	 * Convert the object to its JSON representation.
	 *
	 * @param  int $options
	 *
	 * @return string
	 */
	public function toJson($options = 0)
	{
		$data = [
			'totalFormated' => $this->totalPriceFormatCurrency(),
			'priceFormated' => $this->priceFormatCurrency()
		];

		return json_encode(
			array_merge(
				get_object_vars($this),
				$data
			)
		);
	}}