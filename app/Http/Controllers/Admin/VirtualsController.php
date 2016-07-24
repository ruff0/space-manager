<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Requests\Resources\VirtualForm;
use App\Resources\Models\Virtual;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use Symfony\Component\HttpFoundation\Response;

class VirtualsController extends AdminController
{
	public function __construct()
	{
		$this->current['model'] = 'Virtuales';
		view()->share('current', $this->current);
		parent::__construct();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$this->current['action'] = 'Listado';
		$virtuals = Virtual::all();

		return view('admin.virtuals.index', [
			'current' => $this->current,
			'virtuals'   => $virtuals
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
		$virtual = new Virtual;

		return view('admin.virtuals.create', [
			'current' => $this->current,
			'virtual'    => $virtual
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param VirtualForm $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(VirtualForm $request)
	{
		$virtual = Virtual::create(
			$request->all()
		);

		return redirect()->route('admin.virtuals.index')->with(
			'success', 'El puesto virtual se ha guardado correctamente'
		);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Virtual $virtuals
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(Virtual $virtuals)
	{
		dd($virtuals);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Virtual $virtuals
	 *
	 * @return \Illuminate\Http\Response
	 *
	 */
	public function edit(Virtual $virtuals)
	{
		$this->current['action'] = 'Actualizar';

		return view('admin.virtuals.edit', [
			'current' => $this->current,
			'virtuals'    => $virtuals
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param VirtualForm $request
	 * @param Virtual     $virtuals
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(VirtualForm $request, Virtual $virtuals)
	{

		$virtual = $virtuals->update(
			$request->all()
		);

		return redirect()->route('admin.virtuals.index')->with(
			'success', 'El puesto virtual se ha guardado correctamente'
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 *
	 * @param Virtual $virtuals
	 * @param Request     $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Virtual $virtuals, Request $request)
	{
		$virtuals->delete();

		if ($request->ajax() || $request->wantsJson()) {
			return new JsonResponse([
				'status'  => 'success',
				'message' => 'El puesto virtual se ha borrado correctamente'
			], Response::HTTP_OK
			);
		}

		return redirect()->route('admin.virtuals.index')
		                 ->withStatus('success')
		                 ->withMessage('El puesto virtual se ha borrado correctamente');
	}
}
