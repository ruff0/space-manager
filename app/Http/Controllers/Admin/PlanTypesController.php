<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Requests\Space\CreatePlanTypeForm;
use App\Space\PlanType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use Symfony\Component\HttpFoundation\Response;


class PlanTypesController extends AdminController
{
	public function __construct()
	{
		$this->current['model'] = 'Tipos de suscripción';
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
		$plantypes = PlanType::all();

		return view('admin.plantypes.index', [
			'current'       => $this->current,
			'plantypes' => $plantypes
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
		$plantype = new PlanType;

		return view('admin.plantypes.create', [
			'current'      => $this->current,
			'plantype' => $plantype
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 *
	 * @param CreatePlanTypeForm $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreatePlanTypeForm $request)
	{
		$plantype = PlanType::create($request->all());

		return redirect()->route('admin.plantypes.index')->with(
			'success', 'El tipo de suscripción se ha guardado correctamente'
		);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param PlanType $plantypes
	 *
	 * @return \Illuminate\Http\Response
	 * @internal param int $id
	 *
	 */
	public function show(PlanType $plantypes)
	{
		dd($plantypes);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param PlanType $plantypes
	 *
	 * @return \Illuminate\Http\Response
	 *
	 */
	public function edit(PlanType $plantypes)
	{
		$this->current['action'] = 'Actualizar';

		return view('admin.plantypes.edit', [
			'current'      => $this->current,
			'plantype' => $plantypes
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param PlanType              $plantypes
	 *
	 * @return \Illuminate\Http\Response
	 *
	 */
	public function update(Request $request, PlanType $plantypes)
	{
			if (!$request->has('active')) {
			$request->offsetSet('active', false);
		}

		$plantype = $plantypes->update(
			$request->all()
		);

		return redirect()->route('admin.plantypes.index')->with(
			'success', 'El tipo de suscripción se ha guardado correctamente'
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param PlanType $plantypes
	 *
	 * @param Request      $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(PlanType $plantypes, Request $request)
	{
		$plantypes->delete();

		if ($request->ajax() || $request->wantsJson()) {
			return new JsonResponse([
				'status'  => 'success',
				'message' => 'El tipo de suscripción se ha borrado correctamente'
			], Response::HTTP_OK
			);
		}

		return redirect()->route('admin.plantypes.index')
		                 ->withStatus('success')
		                 ->withMessage('El tipo de suscripción se ha borrado correctamente');
	}
}
