<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Space\CreatePlanForm;
use App\Http\Requests\Space\UpdatePlanForm;
use App\Space\Plan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
use Symfony\Component\HttpFoundation\Response;

class PlansController extends AdminController
{

	public function __construct()
	{
		$this->current['model'] = 'Planes';
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
		$plans = Plan::all();

		return view('admin.plans.index',[
			'current' => $this->current,
			'plans' => $plans
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
		$plan = new Plan;
		return view('admin.plans.create', [
			'current' => $this->current,
			'plan' => $plan
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CreatePlanForm $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreatePlanForm $request)
	{
		$plan = Plan::create(
			$request->all()
		);

		if ($request->has('images')) {
			$plan->images()->sync($request->get('images'));
		}

		return redirect()->route('admin.plans.index')->with(
			'success', 'El plan se ha guardado correctamente'
		);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Plan $plans
	 *
	 * @return \Illuminate\Http\Response
	 *
	 */
	public function show(Plan $plans)
	{
		dd($plans);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Plan $plans
	 *
	 * @return \Illuminate\Http\Response
	 *
	 */
	public function edit(Plan $plans)
	{
		$this->current['action'] = 'Actualizar';

		return view('admin.plans.edit', [
			'current' => $this->current,
			'plan'    => $plans
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 *
	 * @param UpdatePlanForm $request
	 * @param Plan           $plans
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdatePlanForm $request, Plan $plans)
	{
		$plans->update(
			$request->all()
		);

		if ($request->has('images')) {
			$plans->images()->sync($request->get('images'));
		}

		return redirect()->route('admin.plans.index')->with(
			'success', 'El plan se ha guardado correctamente'
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Plan $plans
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Plan $plans, Request $request)
	{
		$plans->delete();

		if ($request->ajax() || $request->wantsJson()) {
			return new JsonResponse([
				'status' =>	'success',
				'message' => 'El plan se ha borrado correctamente'
				], Response::HTTP_OK
			);
		}

		return redirect()->route('admin.plans.index')
			->withStatus('success')
			->withMessage('El plan se ha borrado correctamente');
	}
}
