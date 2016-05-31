<?php

namespace App\Invoices\Models;

use App\Space\Member;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed name
 * @property int   total
 * @property int   vat
 * @property mixed lines
 * @property mixed company_identity
 * @property mixed company_name
 * @property mixed mobile
 * @property mixed phone
 * @property mixed state
 * @property mixed city
 * @property mixed zip
 * @property mixed address_line2
 * @property mixed address_line1
 * @property mixed identity
 * @property mixed lastname
 * @property mixed is_company
 * @property int   tax
 * @property mixed subtotal
 */
class Invoice extends Model
{
	/**
	 * @var int
	 */
	public $vat_percentage = 21;

	/**
	 * @var string
	 */
	public $currency = "€";

	/**
	 * @var string
	 */
	protected $table = 'invoices';

	/**
	 * @var array
	 */
	protected $fillable = ["paid", "type"];

	/**
	 * @var array
	 */
	protected $invoiceLines = [];

	/**
	 * @var array
	 */
	protected $appends = [
		'subtotalFormated',
		'totalFormated',
		'vatFormated'
	];

	public function toMember(Member $member)
	{
		$this->member()->associate($member);

	  $this->name = $member->name;
	  $this->lastname = $member->lastname;
	  $this->identity = $member->identity;
	  $this->address_line1 = $member->address_line1;
	  $this->address_line2 = $member->address_line2;
	  $this->zip = $member->zip;
	  $this->city = $member->city;
	  $this->state = $member->state;
	  $this->phone = $member->phone;
	  $this->mobile = $member->mobile;
	  $this->is_company = $member->is_company;
	  $this->company_name = $member->company_name;
	  $this->company_identity = $member->company_identity;
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function member()
	{
		return $this->belongsTo(Member::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function lines()
	{
		return $this->hasMany(Line::class);
	}
	
	/**
	 * @param $line
	 */
	public function addLine(Line $line)
	{
		array_push($this->invoiceLines, $line);
		$this->lines()->create($line->toArray());
		$this->calculateTotals();
	}


	/**
	 * @param array $lines
	 *
	 */
	public function addLines(array $lines = [])
	{
		foreach ($lines as $line)
		{
			$this->addLine($line);
		}
	}

	/**
	 * @param int $percentage
	 *
	 * @return Invoice
	 */
	public function setVatPercentage($percentage = 0)
	{
		$this->vat_percentage = $percentage;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getSubtotalFormatedAttribute()
	{
		return number_format($this->attributes['subtotal'], 2) . $this->currency;
	}

	/**
	 * @return string
	 */
	public function getTotalFormatedAttribute()
	{
		return number_format($this->attributes['total'], 2) . $this->currency;
	}

	/**
	 * @return string
	 */
	public function getVatFormatedAttribute()
	{
		return number_format($this->attributes['vat'], 2) . $this->currency;
	}

	/**
	 * @param array $values
	 *
	 * @return array|void
	 */
	public function getArrayableItems(array $values)
	{
		$this->calculateTotals();
		parent::getArrayableItems($values);
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

		foreach ($this->invoiceLines as $line)
		{
			$this->subtotal += $line->totalPrice();
		}
	}

	/**
	 * 
	 */
	private function calculateVat()
	{
		$this->tax = ($this->subtotal * ($this->vat_percentage / 100));
		$this->vat = $this->vat_percentage;
	}

	/**
	 * 
	 */
	private function calculateTotal()
	{
		$this->total = ($this->subtotal * (1 + ($this->vat_percentage / 100)));
	}

	/**
	 * @return int
	 */
	public function getTotalForStripe()
	{
		return (int) $this->total;
	}

	/**
	 * @param null $stripe_charge_id
	 *
	 * @return mixed
	 */
	public static function findInvoiceByStripeCharge($stripe_charge_id = null)
	{
		return self::where('charge_id', $stripe_charge_id)->first();
	}

	/**
	 * @param string $type
	 */
	public function getLastInvoiceOfType($type = 'plan')
	{
		return $this->where('type', $type)->last();
	}
}
