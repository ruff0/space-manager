<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Requests\Resources\OfficeForm;
use App\Resources\Models\Office;
use Illuminate\Http\Request;

use App\Http\Requests;

class OfficesController extends AdminController
{
	/**
	 * MeetingRoomsController constructor.
	 */
	public function __construct()
	{
		$this->current['model'] = 'Oficinas';
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
		$offices = Office::all();

		return view('admin.offices.index', [
			'current'      => $this->current,
			'offices' => $offices
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
		$office = new Office;

		return view('admin.offices.create', [
			'current'     => $this->current,
			'office' => $office
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 *
	 * @param OfficeForm $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(OfficeForm $request)
	{
		$office = Office::create(
			$request->all()
		);

		return redirect()->route('admin.offices.index')->with(
			'success', 'La sala de reuniones se ha guardado correctamente'
		);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Office $offices
	 *
	 * @return \Illuminate\Http\Response
	 *
	 */
	public function show(Office $offices)
	{
		dd($offices);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 *
	 * @param Office $offices
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Office $offices)
	{
		$this->current['action'] = 'Actualizar';

		return view('admin.offices.edit', [
			'current'     => $this->current,
			'office' => $offices
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 *
	 * @param OfficeForm $request
	 * @param Office     $offices
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(OfficeForm $request, Office $offices)
	{
		if (!$request->has('active')) {
			$request->offsetSet('active', false);
		}


		$office = $offices->update(
			$request->all()
		);

		return redirect()->route('admin.offices.index')->with(
			'success', 'La sala de reuniones se ha guardado correctamente'
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 *
	 * @param Office  $offices
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Office $offices, Request $request)
	{
		$offices->delete();

		if ($request->ajax() || $request->wantsJson()) {
			return new JsonResponse([
				'status'  => 'success',
				'message' => 'El despacho se ha borrado correctamente'
			], Response::HTTP_OK
			);
		}

		return redirect()->route('admin.offices.index')
		                 ->withStatus('success')
		                 ->withMessage('El despacho se ha borrado correctamente');
	}
}
