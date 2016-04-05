<?php

namespace App\Http\Requests\Team;

use App\Http\Requests\Request;

class UpdateTeamForm extends Request
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
		return [];
	}

	/**
	 * Set custom attributes for validator errors.
	 *
	 * @return array
	 */
	public function attributes()
	{
		return [
			'name'           => 'razón social',
			'identity'       => 'CIF',
			'address[line1]' => 'dirección',
			'city'           => 'ciudad',
			'state'          => 'provincia',
			'zip'            => 'código postal',
			'mobile'         => 'móvil',
			'phone'          => 'télefono',
		];
	}
}
