@extends('layouts.app')

@section('body-class', '')

@section('page-scripts')
	<script src="/js/page/invoices.js"></script>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			@include('common.toolbar')

			{{-- Content area --}}
			<div class="content">

				{{-- User profile --}}
				<div class="row">
					<div class="col-lg-10">
						<div class="tabbable">
							<div class="tab-content">
								<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">Facturas</h6>
									</div>

									<table class="table table-lg invoice-archive">
										<thead>
										<tr>
											<th>#</th>
											<th>Periodo</th>
											<th>A nombre de</th>
											<th>Fecha Factura</th>
											<th>Fecha Cobro</th>
											<th>Cantidad</th>
											<th class="text-center">Acciones</th>
										</tr>
										</thead>
										<tbody>
										@foreach($invoices as $invoice)
											<tr>
											<td>{{ $invoice->number }}</td>
											<td>{{ $invoice->created_at->format('F Y') }}</td>
											<td>
												<h6 class="no-margin">
													<a href="#">{{ $invoice->member->fullname() }}</a>
													<small class="display-block text-muted">Metodo de pago: Stripe</small>
												</h6>
											</td>
											<td>
												{{$invoice->updated_at->format('d F Y')}}
											</td>
											<td>
												<span class="label label-success">
													Pagado el {{$invoice->updated_at->format('d F Y')}}
												</span>
											</td>
											<td>
												<h6 class="no-margin text-bold"> @currencyFormat($invoice->total / 100)
													<small class="display-block text-muted text-size-small">
														IVA @currencyFormat($invoice->tax / 100)
													</small>
												</h6>
											</td>
											<td class="text-center">
												<ul class="icons-list">
													<li>
														<a href="{{ route('invoices.show', [$invoice->id]) }}">
															<i class="icon-file-eye"></i>
														</a>
													</li>
													<li>
														<a href="#">
															<i class="icon-file-download"></i>
														</a>
													</li>
												</ul>
											</td>
										</tr>
										@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-2">
						@include('common.sidebar')
					</div>
				</div>
				{{-- /user profile --}}


				{{-- Footer --}}
				{{--<div class="footer text-muted">--}}
				{{--&copy; 2015. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov"--}}
				{{--target="_blank">Eugene Kopyov</a>--}}
				{{--</div>--}}
				{{-- /footer --}}

			</div>
			{{-- /content area --}}
		</div>
	</div>
@endsection