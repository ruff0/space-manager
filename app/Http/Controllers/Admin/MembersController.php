<?php

namespace App\Http\Controllers\Admin;

use App\Space\Member;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AdminController;
use App\Http\Requests\Space\UpdateMemberForm;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Requests;

class MembersController extends AdminController
{

	/**
	 * UsersController constructor.
	 */
	public function __construct()
	{
		$this->current['model'] = 'Miembros';
		view()->share('current', $this->current);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$this->current['action'] = 'Listado';
		$members = Member::with('users', 'users.profile')->get();

		return view('admin.members.index', [
			'current' => $this->current,
			'members' => $members,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$this->current['action'] = 'Crear';
		$member = new Member;
		return view('admin.members.create',[
			'current' => $this->current,
			'member' => $member
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param UpdateMemberForm $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(UpdateMemberForm $request)
	{
		$member = Member::create(
			$request->all()
		);

		return redirect()->route('admin.members.index')->with(
			'success', 'El miembro se ha guardado correctamente'
		);
	}

	/**
	 * Display the specified resource.
	 *
	 *
	 * @param Member $members
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(Member $members)
	{
		$this->current['action'] = 'Detalles';

		return view('admin.members.show', [
			'current' => $this->current,
			'member' => $members,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 *
	 * @param Member $members
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Member $members)
	{
		$this->current['action'] = 'Actualizar';

		return view('admin.members.edit', [
			'current' => $this->current,
			'member'    => $members
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 *
	 * @param UpdateMemberForm $request
	 * @param Member           $member
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateMemberForm $request, Member $member)
	{
		$member = $member->update(
			$request->all()
		);

		return redirect()->route('admin.members.index')->with(
			'success', 'El miembro se ha guardado correctamente'
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Member $members, Request $request)
	{
		$members->delete();

		if ($request->ajax() || $request->wantsJson()) {
			return new JsonResponse([
				'status'  => 'success',
				'message' => 'El miembro se ha borrado correctamente'
			], Response::HTTP_OK
			);
		}

		return redirect()->route('admin.members.index')
		                 ->withStatus('success')
		                 ->withMessage('El miembro se ha borrado correctamente');
	}
}
