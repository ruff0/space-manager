@extends('layouts.app')

@section('body-class', 'home')

@section('page-scripts')
	<script src="/js/page/home.js"></script>
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
						<div class="panel panel-flat">
							<div class="content pt-20 ">
								<div class="col-md-12 text-center mt-20">
									<h2>Hola {{$user->fullName()}}</h2>
									<h3 class="text-red">Bienvenido a Ideas Meeting Point</h3>
								</div>
								<div class="col-sm-12 text-center mt-20">
									<h3 class="text-red mt-20">¿QUE QUIERES HACER?</h3>
								</div>


								<div class="col-sm-4 col-sm-offset-4 text-center mt-20">
									{{--<a href="/plans" class="btn btn-small btn-warning btn-block">Contratar una subscripción mensual</a>--}}
									<a href="/bookings/create" class="mt-20 mb-20  pb-20 pt-20 btn btn-small btn-info btn-block">Alquilar una sala</a>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-2">
						{{--UserProfile--}}
						<div class="thumbnail">
							<div class="thumb thumb-rounded thumb-slide">
								<img src="{{ $user->avatar(200) }}" alt="" height="200">
								<div class="caption">
										<span>
											<a href="#" class="btn bg-success-400 btn-icon btn-xs legitRipple" data-popup="lightbox">
												<i class="icon-plus2"></i>
											</a>
											<a href="#" class="btn bg-success-400 btn-icon btn-xs legitRipple">
												<i class="icon-link"></i>
											</a>
										</span>
								</div>
							</div>

							<div class="caption text-center">
								<h6 class="text-semibold no-margin">{{$user->name}}
									<small class="display-block">{{$user->email}}</small>
								</h6>
							</div>
						</div>
						{{--/UserProfile--}}
						{{-- Navigation --}}
						<div class="panel panel-flat">
							<div class="list-group no-border">
								<a href="#" class="list-group-item">
									<i class="icon-user"></i> My profile
								</a>
								<div class="list-group-divider"></div>
								<a href="#" class="list-group-item">
									<i class="icon-cog3"></i> Account settings
								</a>
							</div>
						</div>
						{{-- /navigation --}}
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
	@if($user->needsMemberData())
		@include('users.profiles.partials._needsMemberData-modal')
	@endif
@endsection
