@extends('layouts.app')

@section('body-class', 'home')

@section('page-scripts')
	<script>$(".steps-basic").hide()</script>
	<script src="/js/page/bookables.js"></script>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">

			@include('common.toolbar')

			{{-- Content area --}}
			<div class="content">

				<div class="row">
					<div class="col-lg-8 col-lg-offset-2">
						<event-form :event="{{$event->toJson()}}" :booking="{{$booking->id}}"></event-form>
					</div>
					<div class="col-lg-2 pull-right">
						<div class="alert alert-info ">
							<h4>Hola {{$user->fullname()}}</h4> <br>
							<p>
								Para cualquier duda o consulta puedes contactarnos por
								teléfono <a href="tel:+34966444114">+34 966 444 114</a> o
								por email <a href="mailto:info@ulab.es">info@ulab.es</a>.
							</p>

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