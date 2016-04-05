<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class CreateProfileForm extends Request
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
		return [
			'name'           => 'required',
			'lastname'       => 'required',
			'identity'       => 'required',
			'address_line1'  => 'required',
			'city'           => 'required',
			'state'          => 'required',
			'zip'            => 'required',
			'mobile'         => 'required',
			'phone'          => 'required',
		];
	}

	/**
	 * Set custom attributes for validator errors.
	 *
	 * @return array
	 */
	public function attributes()
	{
		return [
			'name'           => 'nombre',
			'lastname'       => 'apellidos',
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
