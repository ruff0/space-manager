@extends('layouts.app')

@section('body-class', 'login-container login-cover')

@section('content')
	<!-- Page content -->
<div class="page-content">

	<!-- Main content -->
	<div class="content-wrapper">

		<!-- Content area -->
		<div class="content pb-20">

			<!-- Tabbed form -->
			<div class="tabbable panel login-form width-400">
				<ul class="nav nav-tabs nav-justified">
					<li class="active">
						<a href="#login" data-toggle="tab">
							<h6>Login</h6>
						</a>
					</li>
					<li>
						<a href="#register" data-toggle="tab">
							<h6>Registrate</h6>
						</a>
					</li>
				</ul>

				<div class="tab-content panel-body">
					<div class="tab-pane fade in active" id="login">
						@include('auth.partials._form-login')
						{{--@include('auth.partials._social-login')--}}
						@include('auth.partials._conditions')
					</div>

					<div class="tab-pane fade in" id="register">
						@include('auth.partials._form-register')
					</div>
				</div>
			</div>
			<!-- /tabbed form -->
		</div>
		<!-- /content area -->

	</div>
	<!-- /main content -->

</div>
<!-- /page content -->

@endsection
