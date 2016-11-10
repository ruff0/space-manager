<?php

namespace App\Http\Requests\Space;

use App\Http\Requests\Request;

class UpdateMemberForm extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		if ($this->has('plan_id')) {
			$rules  = ["plan_id" => "required"];
		} else {
			$rules = [
				'name' => 'required',
				'lastname' => 'required',
				'email' => 'required',
				'identity' => 'required',
				'address_line1' => 'required',
				'city' => 'required',
				'state' => 'required',
				'zip' => 'required',
				'mobile' => 'required',
				'phone' => 'required',
			];

			if ($this->has('company_identity')) {
				$rules = array_merge($rules, [
					'company_identity' => 'required',
					'company_name' => 'required',
				]);
			}
		}

		return $rules;

	}

	/**
	 * Set custom attributes for validator errors.
	 *
	 * @return array
	 */
	public function attributes()
	{
		return [
			'name' => 'nombre',
			'lastname' => 'apellidos',
			'identity' => 'NIF / NIE',
			'address_line1' => 'dirección',
			'address_line2' => 'dirección',
			'city' => 'ciudad',
			'state' => 'provincia',
			'zip' => 'código postal',
			'mobile' => 'móvil',
			'phone' => 'télefono',
			'company_identity' => 'CIF',
			'company_name' => 'razón social',
		];
	}
}
