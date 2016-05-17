@extends('layouts.app')

@section('body-class', 'home')

@section('page-scripts')
	<script src="/js/page/subscriptions.js"></script>
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
							      action="{{url("subscriptions")}}"
							      id="subscriptions-wizzard"
							      data-token="{{csrf_token()}}"
							      method="POST"
							>
								<h6>¿Coworking o despacho?</h6>
								<fieldset class="col-md-12" style="min-height:50vh">
									<div class="row mt-20 pt-20">
										<div class="col-md-6 col-md-offset-3">
											<div class="errors alert alert-danger" style="display:none;"></div>
										</div>
										@foreach($plantypes as $type)
											<div class="col-md-3 col-md-offset-2 col-sm-3 col-sm-offset-2">
												<div class="thumbnail no-padding">
													<div class="thumb">
														<img src="{{$type->mainImage()}}" alt="">
														<div class="caption-overflow">
																<span>
																	<label class="thumb-label btn bg-success-400 btn-icon btn-xs legitRipple">
																		<i class="icon-plus2"></i>
																		<input type="radio" name="plan-type" class="styled" value="{{$type->id}}">
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
								<h6>¿Cuando quieres alquilar la sala?</h6>
								<fieldset class="col-md-12" style="min-height:50vh">
									<div class="row">
										<div class="col-md-8 col-md-offset-2">
											<div class="errors alert alert-danger" style="display:none;"></div>
										</div>
									</div>

									<div class="row mt-20 pt-20">
										<div class="col-md-4 col-md-offset-4">
											<label data-time class="thumb-label btn btn-block bg-success-400 btn-icon btn-xs legitRipple">
												<i class="icon-calendar"></i> Desde hoy
												<input type="radio" name="date_from" class="styled" value="this-month" checked>
											</label>
										</div>
									</div>

									<div class="row mt-20 pt-20">
										<div class="col-md-4 col-md-offset-4">
											<label data-time class="thumb-label btn btn-block bg-info-400 btn-icon btn-xs legitRipple">
												<i class="icon-calendar"></i> Desde primeros del mes que viene
												<input type="radio" name="date_from" class="styled" value="next-month">
											</label>
										</div>
									</div>
								</fieldset>
								<h6>¿Que tipo de sala quieres alquilar?</h6>
								<fieldset class="col-md-12" style="min-height:50vh">
									<div class="row mt-20 pt-20">
										<div class="row">
											<div class="col-md-8 col-md-offset-2">
												<div class="errors alert alert-danger" style="display:none;"></div>
											</div>
										</div>
										@foreach($plantypes as $type)
											@foreach($type->plans as $plan)
												<div class="col-md-3 col-md-offset-2 col-sm-2 col-sm-offset-2">
													<div class="thumbnail no-padding plans blocked" data-type="{{$type->id}}"
													     data-plan="{{$plan->id}}">
														<div class="thumb">
															<img src="{{$plan->mainImage()}}" alt="">
															<div class="caption-overflow">
																<span>
																	<label class="thumb-label btn bg-success-400 btn-icon btn-xs legitRipple">
																		<i class="icon-plus2"></i>
																		<input type="radio" name="plan" class="styled" value="{{$plan->id}}">
																	</label>
																</span>
															</div>
														</div>

														<div class="caption text-center">
															<h6 class="text-semibold no-margin">
																{{$plan->name}}
																<small class="display-block">{{$plan->name}}</small>
															</h6>
														</div>
													</div>
												</div>
											@endforeach
										@endforeach
									</div>
								</fieldset>

								<h6>¿Elige tu sala o puesto?</h6>
								<fieldset class="col-md-12" style="min-height:50vh">
									<div class="row mt-20 pt-20">
										<div class="row">
											<div class="col-md-8 col-md-offset-2">
												<div class="errors alert alert-danger" style="display:none;"></div>
											</div>
										</div>
										@foreach($plantypes as $type)
											@foreach($type->plans as $plan)
												@foreach($plan->roomResources() as $resource)
													<div class="col-md-3 col-md-offset-2 col-sm-2 col-sm-offset-2">
														<div class="thumbnail no-padding rooms blocked" data-type="{{$type->id}}"
														     data-plan="{{$plan->id}}" data-room="{{$resource->resourceable->id}}">
															<div class="thumb">
																<img src="{{$resource->mainImage()}}" alt="">
																<div class="caption-overflow">
																<span>
																	<label class="thumb-label btn bg-success-400 btn-icon btn-xs legitRipple">
																		<i class="icon-plus2"></i>
																		<input type="radio" name="room" class="styled" value="{{$resource->resourceable->id}}">
																	</label>
																</span>
																</div>
															</div>

															<div class="caption text-center">
																<h6 class="text-semibold no-margin">
																	{{$resource->resourceable->name}}
																	<small class="display-block">{{$resource->resourceable->description}}</small>
																</h6>
															</div>
														</div>
													</div>
												@endforeach
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
									<div class="mt-20 pt-20 mb-20 pb-20 col-md-2 pull-right no-padding">
										<img src="/images/secure_payment.png" class="img-responsive" alt="Secure payment">
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