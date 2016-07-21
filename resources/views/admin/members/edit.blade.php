@extends('admin.layouts.admin')

@section('body-class', '')

@section('new-form-text', 'Crear nuevo miembro')
@section('new-form-url', route('admin.members.create'))

@section('content')
	<div class="page-content">

		@include('admin.common.sidebar')
		<div class="content-wrapper">
			@include('admin.common.header')
			<div class="content pb-20">
				<div class="col-sm-9">
					{{--Plans form--}}
					<div class="panel panel-white">
						<div class="panel-heading">
							<h6 class="panel-title">Editar Miembro #{{$member->id}}</h6>
							<div class="heading-elements"></div>
						</div>
						<div class="panel-body">
							<form action="{{ route('admin.members.update', [$member->id]) }}" method="POST">
								{{ method_field('PUT') }}
								@include('admin.members.form')
								<button type="submit" class="btn btn-primary pull-right">Guardar</button>
							</form>
						</div>
					</div>
				</div>

				<div class="col-sm-3">
					@include('admin.plans.partials.panel-plans-form', ['entity' => $member])
					@include('admin.discounts.partials.panel-discounts-form', ['entity' => $member])
					@include('admin.pass.partials.panel-pass-form', ['entity' => $member])
				</div>
			</div>
		</div>
	</div>

@endsection
