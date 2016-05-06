@extends('layouts.app')

@section('body-class', '')

@section('page-scripts')
	{{--<script src="/js/page/home.js"></script>--}}
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
								<div class="panel panel-flat">
									<div class="panel-heading"></div>
									<div class="panel-body">
										@include('members.forms.edit')
									</div>
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

						{{-- Current Plan --}}
						{{--<div class="panel panel-flat">--}}
						<div class="panel panel-flat border-left-lg border-left-danger invoice-grid timeline-content">
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-6">
										<h6 class="text-semibold no-margin-top">{{$member->companyName()}}</h6>
										<ul class="list list-unstyled">
											<li>Plan actual: <span class="text-semibold">{{$member->currentPlan()->name}}</span></li>
										</ul>
									</div>

									<div class="col-sm-6">
										<h6 class="text-semibold text-right no-margin-top">{{$member->companyIdentity()}}</h6>
										<ul class="list list-unstyled text-right">
											<li class="dropdown">
												<div class="label
														{!! $member->active ? 'label-success' : 'label-danger' !!}">
														{!! $member->active ? 'Activo' : 'Inactivo' !!}
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>

							<div class="panel-footer panel-footer-condensed">
								<div class="heading-elements">
									<span class="heading-text">
										<span class="status-mark border-danger position-left"></span>
										Miembro desde:
										<span class="text-semibold">
											{{$member->created_at->format('d/m/Y')}}
										</span>
									</span>

									<ul class="list-inline list-inline-condensed heading-text pull-right">
										<li class="dropdown">
											<a href="#" class="text-default dropdown-toggle" data-toggle="dropdown">
												<i class="icon-menu7"></i>
												<span class="caret"></span>
											</a>
											<ul class="dropdown-menu dropdown-menu-right">
												<li><a href="#"><i class="icon-file-eye"></i> Ver Factura</a></li>
												<li><a href="#"><i class="icon-file-download"></i> Descargar factura</a></li>
												<li class="divider"></li>
												<li><a href="#"><i class="icon-cross2"></i> Cancelar suscripción</a></li>
											</ul>
										</li>
									</ul>
								</div>
							</div>
						</div>
						{{--</div>--}}
						{{-- /Current Plan --}}


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
@endsection