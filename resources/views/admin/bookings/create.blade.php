@extends('admin.layouts.admin')

@section('body-class', '')

@section('new-form-text', 'Crear nueva reserva')
@section('new-form-url', route('admin.bookings.create'))

@section('content')
	<!-- Page content -->
<div class="page-content">

	@include('admin.common.sidebar')

		<!-- Main content -->
	<div class="content-wrapper">
		@include('admin.common.header')
			<!-- Content area -->
		<div class="content pb-20">
			@include('admin.bookings.form')
			<!-- /task manager table -->
		</div>
		<!-- /content area -->

	</div>
	<!-- /main content -->

</div>
<!-- /page content -->

@endsection
