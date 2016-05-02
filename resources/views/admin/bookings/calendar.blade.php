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
			<div class="panel panel-white">
				<scheduler :events="{{ $bookings->toJson() }}"
				:resources="{{ $resources->toJson() }}"
				></scheduler>
			</div>
		</div>
	</div>
</div>
@endsection
