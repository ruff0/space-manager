<?php

namespace App\Http\Controllers\Space;

use App\Http\Requests\Space\UpdateMemberForm;
use App\Space\Member;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MembersController extends Controller
{

	/**
	 * @param Member $members
	 *
	 * @return mixed
	 */
	public function edit(Member $members)
	{
 	  return view('members.edit', [
	   'member' =>  $members
    ]);
	}

	/**
	 * @param Member           $members
	 * @param UpdateMemberForm $request
	 *
	 * @return
	 */
	public function update(Member $members, UpdateMemberForm $request)
	{
		$data = $request->all();

		if($request->has('company_identity'))
			$data['is_company'] = true;

		$members->update($data);

		return redirect()->route('members.edit', [ $members->id ]);
	}
}
