@extends('admin.layouts.admin')

@section('body-class', '')

@section('new-form-text', 'Crear nueva reserva')
@section('new-form-url', route('admin.bookings.create'))

@section('content')
	<div class="page-content">
		@include('admin.common.sidebar')
		<div class="content-wrapper">
			@include('admin.common.header')
			<div class="content pb-20">
				@include('admin.bookings.form')
			</div>
		</div>
	</div>
@endsection
