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
		$members->update($request->all());

		return redirect()->route('members.edit', [ $members->id ]);
	}
}
