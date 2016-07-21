@extends('admin.layouts.admin')

@section('body-class', '')

@section('new-form-text', 'Crear nuevo plan')
@section('new-form-url', route('admin.plans.create'))

@section('content')
	<!-- Page content -->
<div class="page-content">

	@include('admin.common.sidebar')

		<!-- Main content -->
	<div class="content-wrapper">
		@include('admin.common.header')
			<!-- Content area -->
		<div class="content pb-20">
			<!-- Task manager table -->
			<div class="panel panel-white">
				<div class="panel-heading">
					<h6 class="panel-title">Planes</h6>
					<div class="heading-elements">
						<ul class="icons-list">
							<li><a data-action="collapse"></a></li>
						</ul>
					</div>
				</div>

				<table class="table plans-list table-lg">
					<thead>
					<tr>
						<th>#</th>
						<th>Nombre</th>
						<th>Descripción</th>
						<th>Precio</th>
						<th>Activo</th>
						<th>Ultima actualización</th>
						<th class="text-center text-muted" style="width: 30px;">
							<i class="icon-checkmark3"></i>
						</th>
					</tr>
					</thead>
					<tbody>
					@foreach($plans as $plan)
						<tr data-plan="{{$plan->id}}">
							<td>#{{$plan->id}}</td>
							<td>{{$plan->name}}</td>
							<td>
								<div class="text-muted">
									{{$plan->description}}
								</div>
							</td>
							<td>
								@currencyFormat($plan->price)
							</td>
							<td>
									<a href="#" class="label
										{!! $plan->active ? 'label-success' : 'label-danger' !!}">
										{!! $plan->active ? 'Activo' : 'Inactivo' !!}
									</a>
							</td>
							<td>
								<i class="icon-calendar2 position-left"></i>
								{{ $plan->updated_at->format('d M Y H:i')  }}
							</td>
							<td class="text-center">
								<ul class="icons-list">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li>
												<a href="{{ route('admin.plans.edit', [$plan->id]) }}">
													<i class="icon-pencil7"></i> Editar plan
												</a>
											</li>
											<li>
												<a href="{{route('admin.plans.destroy', [$plan->id])}}"
												   role="delete-form"
													 data-id="{{$plan->id}}"
													 data-token="{{ csrf_token() }}"
												>
													<i class="icon-cross2 position-left"></i>
													Remove
												</a>
											</li>
										</ul>
									</li>
								</ul>
							</td>
						</tr>
					@endforeach

					</tbody>
				</table>
			</div>
			<!-- /task manager table -->
		</div>
		<!-- /content area -->

	</div>
	<!-- /main content -->

</div>
<!-- /page content -->

@endsection
