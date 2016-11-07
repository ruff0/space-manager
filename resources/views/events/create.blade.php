@extends('layouts.app')

@section('body-class', 'home')

@section('page-scripts')
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">

			@include('common.toolbar')

			{{-- Content area --}}
			<div class="content">

				<div class="row">
					<div class="col-lg-10 col-lg-offset-1">
						<event :event="{{$event->toJson()}}" :booking="{{$booking->toJson()}}"></event>
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