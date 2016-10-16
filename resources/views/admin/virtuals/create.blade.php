@extends('admin.layouts.admin')

@section('body-class', '')

@section('new-form-text', 'Crear nuevo puesto virtual')
@section('new-form-url', route('admin.virtuals.create'))

@section('content')
	<!-- Page content -->
<div class="page-content">

	@include('admin.common.sidebar')

		<!-- Main content -->
	<div class="content-wrapper">
		@include('admin.common.header')
			<!-- Content area -->
		<div class="content pb-20">
			{{--Plans form--}}
			<div class="panel panel-white">
				<div class="panel-heading">
					<h6 class="panel-title">Crear puesto virtual</h6>
					<div class="heading-elements"></div>
				</div>
				<div class="panel-body">
					<form action="{{ route('admin.virtuals.store') }}" method="POST">

						@include('admin.virtuals.form')
						<button type="submit" class="btn btn-primary pull-right">Guardar</button>
					</form>
				</div>


			</div>
			<!-- /task manager table -->
		</div>
		<!-- /content area -->

	</div>
	<!-- /main content -->

</div>
<!-- /page content -->

@endsection
