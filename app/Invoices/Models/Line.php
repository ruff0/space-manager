<?php

namespace App\Invoices\Models;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
	protected $table = "lines";
	
	protected $fillable = [
		"name",
		"description",
		"price",
		"amount",
		"subtotal"
	];

	protected $currency = "€";

	protected $appends = [
		'totalFormated',
		'priceFormated'
	];

	public function invoice()
	{
		return $this->belongsTo(Invoice::class);
	}

	public function setPriceAttribute($value)
	{
		$this->attributes['price'] = (int) $value;

		$this->setSubtotal();
	}

	public function setAmountAttribute($value)
	{
		$this->attributes['amount'] = (int) $value;

		$this->setSubtotal();
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
		return $this->price * $this->amount;
	}


	/**
	 *
	 */
	public function totalPriceFormatCurrency()
	{
		return number_format($this->price() * $this->amount, 2) . $this->currency;
	}

	public function getTotalFormatedAttribute()
	{
		return $this->totalPriceFormatCurrency();
	}


	public function getPriceFormatedAttribute()
	{
		return $this->priceFormatCurrency();
	}

	private function setSubtotal()
	{
		$this->attributes['subtotal'] = ($this->price * $this->amount);
	}

}

