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