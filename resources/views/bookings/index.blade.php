@extends('layouts.app')

@section('body-class', 'home')

@section('page-scripts')
	<script src="/js/page/bookables.js"></script>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">

			@include('common.toolbar')

			{{-- Content area --}}
			<div class="content">

				{{-- User profile --}}
				<div class="row">
					<div class="col-lg-8 col-lg-offset-2">
						<div class="panel panel-white p-20">
							<div class="panel-heading">
								<h6 class="panel-title">Reserva tu sala o puesto</h6>
							</div>

							<form class="steps-basic row"
							      action="{{url("bookings")}}"
							      id="bookings-wizzard"
							      data-token="{{csrf_token()}}"
							      method="POST"
							>
								<h6>¿Salas o despachos?</h6>
								<fieldset class="col-md-12" style="min-height:50vh">
									<div class="row mt-20 pt-20">
										<div class="col-md-6 col-md-offset-3">
											<div class="errors alert alert-danger" style="display:none;"></div>
										</div>
										@foreach($bookableTypes as $type)
											<div class="col-md-2 col-md-offset-3">
												<div class="thumbnail no-padding">
													<div class="thumb">
														<img src="/images/placeholder.jpg" alt="">
														<div class="caption-overflow">
																<span>
																	<label class="thumb-label btn bg-success-400 btn-icon btn-xs legitRipple">
																		<i class="icon-plus2"></i>
																		<input type="radio" name="bookable-type" class="styled" value="{{$type->id}}">
																	</label>
																</span>
														</div>
													</div>

													<div class="caption text-center">
														<h6 class="text-semibold no-margin">
															{{$type->name}}
															<small class="display-block">{{$type->name}}</small>
														</h6>
													</div>
												</div>
											</div>
										@endforeach
									</div>
								</fieldset>
								<h6>¿Que sala quieres alquilar?</h6>
								<fieldset class="col-md-12" style="min-height:50vh">
									<div class="row">
										<div class="col-md-8 col-md-offset-2">
											<div class="errors alert alert-danger" style="display:none;"></div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>Fecha</label>
												<div class="input-group">
													<span class="input-group-addon"><i class="icon-calendar5"></i></span>
													<input type="text" class="form-control pickadate-date" placeholder="¿Elije una fecha?">
												</div>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label>Hora inicio</label>
												<div class="input-group">
													<span class="input-group-addon"><i class="icon-alarm"></i></span>
													<input type="text" placeholder="¿Desde que hora?" class="form-control pickatime-from">
												</div>

											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label>Hora fin</label>
												<div class="input-group">
													<span class="input-group-addon"><i class="icon-alarm"></i></span>
													<input type="text" placeholder="¿Desde que hora?"
													       class="form-control pickatime-to">
												</div>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label>&nbsp;</label>
												<button type="button" class="btn btn-block btn-warning" id="search">Buscar</button>
											</div>
										</div>

										@foreach($bookableTypes as $type)
											@foreach($type->bookables as $bookable)
												{{--<div class="col-md-2">--}}
													{{--<label class="bookables" >--}}
														{{----}}
														{{--{{$bookable->name}}--}}
													{{--</label>--}}
												{{--</div>--}}
												<div class="col-md-2">
													<div class="thumbnail no-padding bookables" data-bookableType="{{$type->id}}"
													     data-bookable="{{$bookable->id}}">
														<div class="thumb">
															<img src="/images/placeholder.jpg" alt="">
															<div class="caption-overflow">
																<span>
																	<label class="thumb-label btn bg-success-400 btn-icon btn-xs legitRipple">
																		<i class="icon-plus2"></i>
																		<input type="radio" name="bookable" class="styled" value="{{$bookable->id}}">
																	</label>
																</span>
															</div>
														</div>

														<div class="caption text-center">
															<h6 class="text-semibold no-margin">
																{{$bookable->name}}
																<small class="display-block">{{$bookable->name}}</small>
															</h6>
														</div>
													</div>
												</div>
											@endforeach
										@endforeach
									</div>
								</fieldset>
								<h6>¿Detalles del pedido?</h6>
								<fieldset class="col-md-12" style="min-height:50vh">

									<div>
										<div class="errors alert alert-danger" style="display:none;"></div>
										<div class="success alert alert-success" style="display:none;"></div>
										<div class="table-responsive">
											<table class="table table-striped" id="pre_bill">
												<thead>
												<tr class="bg-slate-600">
													<th colspan="2">Concepto</th>
													<th>Precio</th>
													<th>Cantidad</th>
													<th>Total</th>
												</tr>
												</thead>
												<tfoot>
												<tr>
													<th colspan="4">Subtotal</th>
													<th id="subtotal"></th>
												</tr>
												<tr>
													<th colspan="4">IVA <span id="vat_percentage"></span></th>
													<th id="vat"></th>
												</tr>
												<tr>
													<th colspan="4">Total</th>
													<th id="total"></th>
												</tr>
												</tfoot>
												<tbody>
												{{--<tr>--}}
												{{--<td class="concept"></td>--}}
												{{--<td class="image"></td>--}}
												{{--<td class="price"></td>--}}
												{{--<td class="qty"></td>--}}
												{{--<td class="line_total"></td>--}}
												{{--</tr>--}}
												</tbody>
											</table>
										</div>
									</div>
								</fieldset>
							</form>
						</div>
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

	@include('members.partials._needsPaymentMethod-modal')

@endsection

@section('vendor-scripts')
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
	<script>
		Stripe.setPublishableKey('{{config('services.stripe.key')}}');
	</script>
@endsection