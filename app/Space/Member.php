<?php

namespace App\Space;

use App\Events\Space\MemberFilledData;
use App\Events\Space\MemberRegistered;
use App\User\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed is_company
 * @property mixed identity
 * @property mixed company_identity
 * @property mixed company_name
 * @property mixed name
 */
class Member extends Model
{
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
		if(!$this->hasIdentity()) return true;
		if(!$this->hasName()) return true;

		return false;
	}
	public function fullName()
	{
		return $this->name . ' ' . $this->lastname;
	}

	/**
	 * Returns whether the company name or the person name depending
	 * if its a company or not.
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
	 * @return bool
	 */
	protected function hasIdentity()
	{
		if($this->isCompany())
		{
			return $this->company_identity?:false;
		}

		return $this->identity ?: false;
	}

	/**
	 * Whether the member is a company or not
	 * @return mixed
	 */
	public function isCompany()
	{
		return $this->is_company;
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function users()
	{
		return $this->hasMany(User::class);
	}

	/**
	 * The main user for this member
	 * @return mixed
	 */
	public function mainUser()
	{
		return $this->users()->first();
	}

	/**
	 * Whether this member has users assigned or not
	 * @return mixed
	 */
	public function hasNoUsers()
	{
		return ! $this->mainUser();
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
			list($user , $profile) = event(
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
}
