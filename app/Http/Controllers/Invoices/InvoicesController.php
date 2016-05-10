<?php

namespace App\Http\Controllers\Invoices;

use App\Invoices\Models\Invoice;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InvoicesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$member = auth()->user()->member;
		$invoices = Invoice::where('member_id', $member->id)
			->where('number', '<>', 'null')
			->where('paid', true)
			->get();

		return view('invoices.index', [
			 'invoices' => $invoices
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$member = auth()->user()->member;
		$invoice = Invoice::where('member_id', $member->id)
		                   ->where('id', $id)
		                   ->where('paid', true)
		                   ->first();

		return view('invoices.show', [
			'invoice' => $invoice
		]);
	}

	public function download($id)
	{

	}
}
