<?php

namespace App\Space;

use App\Bookings\Booking;
use App\Events\Space\MemberFilledData;
use App\Events\Space\MemberRegistered;
use App\Invoices\Models\Invoice;
use App\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;
use Laravel\Cashier\StripeGateway;

/**
 * @property mixed is_company
 * @property mixed identity
 * @property mixed company_identity
 * @property mixed company_name
 * @property mixed name
 * @property mixed address_line1
 * @property mixed address_line2
 * @property mixed lastname
 * @property mixed zip
 * @property mixed city
 * @property mixed state
 * @property mixed phone
 * @property mixed mobile
 * @property mixed isCompany
 * @property mixed subscriptions
 * @property mixed discounts
 */
class Member extends Model
{
	use Billable;

	/**
	 * Fillable fields
	 */
	protected $fillable = [
		'name',
		'lastname',
		'email',
		'identity',
		'address_line1',
		'address_line2',
		'zip',
		'city',
		'state',
		'phone',
		'mobile',
		'is_company',
		'company_name',
		'company_identity',
	];

	/**
	 * Return the user avatar
	 *
	 * @param int $size Size for the avatar image
	 *
	 * @return string
	 */
	public function avatar($size = 40)
	{
		return "http://www.gravatar.com/avatar/" . md5(strtolower(trim($this->email))) . "?s=" . $size;
	}

	/**
	 * Whether the member needs to fill data in for the member profile
	 */
	public function needsFillData()
	{
		if (!$this->hasIdentity()) {
			return true;
		}
		if (!$this->hasName()) {
			return true;
		}

		return false;
	}

	public function fullName()
	{
		return $this->name . ' ' . $this->lastname;
	}

	/**
	 * Returns whether the company name or the person name depending
	 * if its a company or not.
	 *
	 * @return mixed
	 */
	public function companyName()
	{
		if ($this->isCompany()) {
			return $this->company_name;
		}

		return $this->fullName();
	}

	/**
	 * Returns whether the company name or the person name depending
	 * if its a company or not.
	 *
	 * @return mixed
	 */
	public function companyIdentity()
	{
		if ($this->isCompany()) {
			return $this->company_identity;
		}

		return $this->identity;
	}

	/**
	 * Whether the member has already a name assigned or not
	 */
	protected function hasName()
	{
		if ($this->isCompany()) {
			return $this->company_name ?: false;
		}

		return $this->name ?: false;
	}

	/**
	 * Whether the member has Identity already assigned or not
	 *
	 * @return bool
	 */
	protected function hasIdentity()
	{
		if ($this->isCompany()) {
			return $this->company_identity ?: false;
		}

		return $this->identity ?: false;
	}

	/**
	 * Whether the member is a company or not
	 *
	 * @return mixed
	 */
	public function isCompany()
	{
		return $this->is_company;
	}

	#######################################################################################
	# Relations
	#######################################################################################
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function users()
	{
		return $this->hasMany(User::class);
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function discounts()
	{
		return $this->hasMany(Discount::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function passes()
	{
		return $this->hasMany(Pass::class);
	}

	/**
	 * @param $type
	 */
	public function hasDiscount($type)
	{
		return $this->discounts()->where('type', $type)->first();
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function bookings()
	{
		return $this->hasMany(Booking::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function subscriptions()
	{
		return $this->hasMany(Subscription::class);
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function subscription()
	{
		if($this->subscriptions)
			return $this->subscriptions->first();

		return new $this->subscriptions();
	}

	/**
	 * The main user for this member
	 *
	 * @return mixed
	 */
	public function mainUser()
	{
		return $this->users()->first();
	}

	/**
	 * Whether this member has users assigned or not
	 *
	 * @return mixed
	 */
	public function hasNoUsers()
	{
		return !$this->mainUser();
	}

	/**
	 * Save a new model and return the instance.
	 *
	 * @param  array $attributes
	 *
	 * @return static
	 */
	public static function create(array $attributes = [])
	{
		$member = parent::create($attributes);

		if ($member && $member->hasNoUsers()) {
			// Call event
			list($user, $profile) = event(
				new MemberRegistered($member)
			);
		}

		return $member;
	}

	/**
	 * Update the model in the database.
	 *
	 * @param  array $attributes
	 * @param  array $options
	 *
	 * @return bool|int
	 */
	public function update(array $attributes = [], array $options = [])
	{
		$entity = parent::update($attributes, $options);

		if ($entity && $this->mainUser()->needsProfile()) {
			// Call event
			list($profile) = event(new MemberFilledData($this));
		}

		return $entity;
	}

	/**
	 * @return string
	 */
	public function getCurrency()
	{
		return "eur";
	}

	/**
	 * Determine if the entity is on the given plan.
	 *
	 * @param Plan $plan
	 *
	 * @return bool
	 */
	public function onPlan(Plan $plan)
	{
		return !is_null($this->subscriptions->first(function ($key, $value) use ($plan) {
			return $value->plan_id === $plan->id;
		}));
	}

	/**
	 * Returns the current plan
	 *
	 * @return mixed
	 */
	public function currentPlan()
	{
		if($this->currentSubscription())
			return $this->currentSubscription()->plan;
	}

	/**
	 * Returns the current subscription instance
	 *
	 * @return mixed
	 */
	public function currentSubscription()
	{
		if($this->subscriptions->count())
			return $this->subscriptions->first();
	}

	/**
	 * @return bool
	 */
	public function hasPlan()
	{
		if(!$this->currentPlan() || $this->onPlan(Plan::byDefault()))
			return false;

		return true;
	}

	/**
	 *
	 */
	public function isOnGracePeriod()
	{
	  if($this->hasPlan()) {
		 return ($this->currentSubscription()->finish()->isFuture() ||
		         $this->currentSubscription()->finish()->isToday()) ;
	  }

		return false;
	}

	/**
	 * @param null $type
	 *
	 * @return \Illuminate\Support\Collection|string
	 */
	public function appliedDiscounts($type = null)
	{
		$finalDiscounts = [
			'plans'    => [
				'percentage' => 0,
				'date_to'    => null
			],
			'bookings' => [
				'percentage' => 0,
				'date_to'    => null
			],
			'events'   => [
				'percentage' => 0,
				'date_to'    => null
			],
		];

		foreach($this->discounts as $discount)
		{
			$finalDiscounts[$discount->type] = [
				'percentage' => $discount->percentage,
				'date_to' => $discount->date_to->format('l\, d M\, Y')
			];
		}

		if($type && isset($finalDiscounts[$type]))
		{
			return collect($finalDiscounts[$type]);
		}


		return collect($finalDiscounts)->toJson();
	}

	public function getCurrentSubscriptionInvoice()
	{
		$invoice = Invoice::where('member_id', $this->id)
		                   ->where('number', '<>', 'null')
		                   ->where('paid', true)
												->get()
		                   ->last();
		return $invoice;
	}


}
