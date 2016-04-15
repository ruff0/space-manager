@extends('admin.layouts.admin')

@section('body-class', '')

@section('new-form-text', 'Crear nueva sala de reuniones')
@section('new-form-url', route('admin.meetingrooms.create'))

@section('content')
	<div class="page-content">
		@include('admin.common.sidebar')
		<div class="content-wrapper">
			@include('admin.common.header')
			<div class="content pb-20">
				<div class="panel panel-white">
					<div class="panel-heading">
						<h6 class="panel-title">Editar sala de reuniones</h6>
						<div class="heading-elements"></div>
					</div>
					<div class="panel-body">
						<form action="{{ route('admin.meetingrooms.update', [$meetingroom->id]) }}" method="POST">
							{{ method_field('PUT') }}
							@include('admin.meetingrooms.form')
							<button type="submit" class="btn btn-primary pull-right">Guardar</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
