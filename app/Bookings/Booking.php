<?php

namespace App\Bookings;

use App\Bookables\Bookable;
use App\Invoices\Models\Invoice;
use App\Resources\Models\Resource;
use App\Space\Member;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
	/**
	 * @var string
	 */
	protected $table = 'bookings';

	/**
	 * @var array
	 */
	protected $fillable = ['time_from', 'time_to'];

	/**
	 * @var array
	 */
	protected $dates = ['time_from', 'time_to'];

	/**
	 * @var array
	 */
	protected $appends = ['paid', 'isNew'];

	/**
	 * Get all of the owning bookable models.
	 */
	public function bookable()
	{
		return $this->belongsTo(Bookable::class);
	}


	/**
	 * Get all of the owning bookable models.
	 */
	public function resource()
	{
		return $this->belongsTo(Resource::class);
	}


	/**
	 * Get all of the owning member models.
	 */
	public function member()
	{
		return $this->belongsTo(Member::class);
	}

	/**
	 *
	 */
	public function invoice()
	{
		return Invoice::where('type', 'booking')
			->where('payable_id', $this->id)
			->first();
	}

	/**
	 * @return bool
	 */
	public function getPaidAttribute()
	{
		$invoice = $this->invoice();

		if($invoice) return $invoice->paid;

		return false;
	}

	/**
	 * @return bool
	 */
	public function getIsNewAttribute()
	{
		return !$this->exists;
	}

	/**
	 * @return bool
	 */
	public function isPaid()
	{
		return $this->getPaidAttribute();
	}

	/**
	 * 
	 */                 
	public function pay($payload = [])
	{
		$this->invoice()->pay();		
	}

	/**
	 * 
	 */
	public function markAsPaid()
	{
		$this->invoice()->markAsPaid('cash');
	}
}
