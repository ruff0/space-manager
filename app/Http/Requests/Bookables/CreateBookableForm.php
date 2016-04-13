<?php

namespace App\Http\Requests\Bookables;

use App\Http\Requests\Request;

class CreateBookableForm extends Request
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
			'name' => 'required',
			'bookable_type_id' => 'required',
			'max_occupants' => 'required|numeric'
		];
	}
}
