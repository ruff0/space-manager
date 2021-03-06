<?php

namespace App\Http\Controllers\User;

use App\Events\User\UserCreatedProfile;
use App\Http\Requests\User\CreateProfileForm;
use App\User\User;
use App\User\Profile;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProfilesController extends Controller
{
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param User    $users
	 * @param Profile $profiles
	 *
	 * @return \Illuminate\Http\Response
	 * @internal param int $id
	 */
	public function edit(User $users, Profile $profiles)
	{
		return view('users.profiles.edit', [
			'profile' => $profiles,
			'user'    => $users
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param User                      $users
	 * @param Profile                   $profiles
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 * @internal param int $id
	 *
	 */
	public function update(User $users, Profile $profiles, Request $request)
	{
		$profiles->update($request->all());

		return redirect()->route('users.profiles.edit', [
			$users->id,
			$profiles->id
		]);
	}

}
