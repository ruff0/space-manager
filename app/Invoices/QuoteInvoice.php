<?php  namespace App\Invoices;


use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

class QuoteInvoice implements Jsonable
{

	public $vatPercentage = 21;

	public $vat = 0;

	public $subtotal = 0;

	public $total = 0;

	public $currency = "€";

	/**
	 * Array of invoice lines
	 * @var array
	 */
	public $lines = [];

	public function __construct($lines = [])
	{

		$this->lines = new Collection();

		if(!is_array($lines))
		{
			$lines = [$lines];
		}

		$this->addLines($lines);
	}
	
	/**
	 * The string representation of this invoice
	 * @return mixed
	 */
	public function __toString()
	{
		return $this->toJson();
	}

	/**
	 * @param $line
	 */
	public function addLine(QuoteLine $line)
	{
		$this->lines->push($line);

		$this->calculateTotals();
	}

	/**
	 * @param array $lines
	 *
	 */
	public function addLines(array $lines = [])
	{
		foreach ($lines as $line) {
			if (!$line instanceof QouteLine) {
				throw new \InvalidArgumentException('Instance of \'App\\Invoices\\Line\' expected');
			}
			$this->addLine($line);
		}
	}

	/**
	 * @return mixed
	 */
	public function count()
	{
		return count($this->lines);
	}

	/**
	 * @param int $percentage
	 *
	 * @return Invoice
	 */
	public function setVatPercentage($percentage = 0)
	{
		$this->vatPercentage = $percentage;

		return $this;
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
			'subtotalFormated' => number_format($this->subtotal, 2) . $this->currency,
			'totalFormated' => number_format($this->total, 2) . $this->currency,
			'vatFormated' => number_format($this->vat, 2) . $this->currency
		];

		return json_encode(
			array_merge(
				get_object_vars($this),
				$data
			)
		);
	}



	/**
	 * 
	 */
	private function calculateTotals()
	{
		$this->calculateSubtotal();
		$this->calculateVat();
		$this->calculateTotal();
	}

	/**
	 *
	 */
	private function calculateSubtotal()
	{
		$this->subtotal = 0;

		foreach ($this->lines as $line)
		{
			$this->subtotal += $line->totalPrice();
		}
	}

	private function calculateVat()
	{
		$this->vat = ($this->subtotal *  ($this->vatPercentage / 100));
	}

	private function calculateTotal()
	{
		$this->total = ($this->subtotal * (1 + ($this->vatPercentage / 100)));
	}

}