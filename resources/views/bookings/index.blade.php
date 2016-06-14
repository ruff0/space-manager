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
								<h6 class="panel-title">Reserva tu espacio</h6>
							</div>

							<form class="steps-basic row"
							      action="{{url("bookings")}}"
							      id="bookings-wizzard"
							      data-token="{{csrf_token()}}"
							      method="POST"
							>
								<h6>¿Qué buscas?</h6>
								<fieldset class="col-md-12" style="min-height:50vh">
									<div class="row">
										<div class="col-md-12">
											<div class="errors alert alert-danger" style="display:none;"></div>
										</div>
									</div>
									<div class="flexbox-container mt-20 pt-20">
										@foreach($bookableTypes as $type)
											<div class="flexbox-item-sm-3 flexbox-item-xs-10 flexbox-item-xsh-4">
												<div class="thumbnail no-padding">
													<div class="thumb">
														<img src="{{$type->mainImage()}}" alt="">
														<div class="caption-overflow">
																<span>
																	<label class="thumb-label btn bg-info-400 btn-icon btn-xs legitRipple">
																		<i class="icon-plus2"></i>
																		<i class="icon-checkmark"></i>
																		<input type="radio" name="bookable-type" class="styled" value="{{$type->id}}"
																		       data-bookableTypeNotVisible="{{$type->slug}}" >
																	</label>
																</span>
														</div>
													</div>

													<div class="caption text-center">
														<h6 class="text-semibold no-margin">
															{{$type->name}}
															<small class="display-block">
																{{--{{$type->description}}--}}
															</small>
														</h6>
													</div>
												</div>
											</div>
										@endforeach
									</div>

								</fieldset>
								<h6>¿Cuando?</h6>
								<fieldset class="col-md-12 search-form pt-20" style="min-height:50vh">
									<div class="row">
										<div class="col-md-12">
										<div class="errors alert alert-danger" style="display:none;"></div>
									</div>
									</div>
									<div class=" flexbox-container">
										<div class="flexbox-item-sm-3 flexbox-item-xs-10 flexbox-item-xsh-4">
											<div class="form-group">
												<label for="date">Fecha</label>
													<input type="text" id="date" name="date" class="form-control pickadate-date" placeholder="¿Elije una fecha?">
											</div>
										</div>
										<div class="flexbox-item-sm-2 flexbox-item-xs-10 flexbox-item-xsh-4"
										     data-notVisible="coworking">
											<div class="form-group">
												<label>Hora inicio</label>
													<input type="text" placeholder="¿A qué hora empieza?" class="form-control pickatime-from">
											</div>
										</div>
										<div class="flexbox-item-sm-2 flexbox-item-xs-10 flexbox-item-xsh-4"
										     data-notVisible="coworking">
											<div class="form-group">
												<label>Hora fin</label>
													<input type="text" placeholder="¿A qué hora termina?" class="form-control pickatime-to">
											</div>
										</div>
									</div>
									<div class=" flexbox-container pt-20 pb-20">
										{{--{!! dd($bookableTypes) !!}--}}
										@foreach($bookableTypes as $type)
											@foreach($type->bookables as $bookable)
												{{--<div class="">--}}
													<div class="flexbox-item-sm-3 flexbox-item-xs-10 flexbox-item-xsh-4
																			thumbnail no-padding bookables blocked"
													     data-bookableType="{{$type->id}}"
													     data-bookable="{{$bookable->id}}">
														<div class="thumb">
															<img src="{{$bookable->mainImage()}}" alt="">
															<div class="caption-overflow">
																<p class="times text-center pt-20 mt-20"></p>
																<span>
																	<label class="thumb-label btn bg-info-400 btn-icon btn-xs legitRipple">

																		<div class="plus">
																			Reservar <i class="icon-cross2"></i>
																			<b class="total-price text-center"></b>
																		</div>

																		<i class="icon-checkmark"></i>

																		<input type="radio" name="bookable" class="styled" value="{{$bookable->id}}">
																	</label>
																</span>

																<p class="pt-20 mt-20"></p>
																<p class="message text-center pt-20 mt-20"></p>
															</div>
														</div>
														<div class="caption info">
															<span class="pull-left">
																<i class="icon-user"></i>
																{{$bookable->max_occupants }}
															</span>
															<span class="pull-right">
																@currencyFormat($bookable->pricePerHour())/Hora
															</span>
														</div>
														<div class="caption text-center">
															<h6 class="text-semibold no-margin">
																{{$bookable->name}}
																<small class="display-block">
																	{{--{{$bookable->description}}--}}
																</small>
															</h6>
														</div>
													</div>
												{{--</div>--}}
											@endforeach
										@endforeach
									</div>
								</fieldset>
								<h6>Detalles</h6>
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

									<div class="mt-20 pt-20 mb-20 pb-20 col-md-2 pull-right no-padding"></div>
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