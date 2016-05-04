@extends('admin.layouts.admin')

@section('body-class', '')

@section('new-form-text', 'Crear nuevo tipo de suscripcion')
@section('new-form-url', route('admin.plantypes.create'))

@section('content')
	<div class="page-content">
		@include('admin.common.sidebar')
		<div class="content-wrapper">
			@include('admin.common.header')
			<div class="content pb-20">
				<div class="panel panel-white">
					<div class="panel-heading">
						<h6 class="panel-title">Editar tipo de suscripcion</h6>
						<div class="heading-elements"></div>
					</div>
					<div class="panel-body">
						<form action="{{ route('admin.plantypes.update', [$plantype->id]) }}" method="POST">
							{{ method_field('PUT') }}
							@include('admin.plantypes.form')
							<button type="submit" class="btn btn-primary pull-right">Guardar</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
