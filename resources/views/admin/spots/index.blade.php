@extends('admin.layouts.admin')

@section('body-class', '')

@section('new-form-text', 'Crear nuevo puesto')
@section('new-form-url', route('admin.spots.create'))

@section('content')
<div class="page-content">

	@include('admin.common.sidebar')
	<div class="content-wrapper">
		@include('admin.common.header')
		<div class="content pb-20">
			<div class="panel panel-white">
				<div class="panel-heading">
					<h6 class="panel-title">Puestos Coworking</h6>
					<div class="heading-elements">
						<ul class="icons-list">
							<li><a data-action="collapse"></a></li>
						</ul>
					</div>
				</div>

				<table class="table spots-list table-lg">
					<thead>
					<tr>
						<th>#</th>
						<th>Nombre</th>
						<th>Descripción</th>
						<th>Activo</th>
						<th>Ultima actualización</th>
						<th class="text-center text-muted" style="width: 30px;">
							<i class="icon-checkmark3"></i>
						</th>
					</tr>
					</thead>
					<tbody>
					@foreach($spots as $spot)
						<tr data-plan="{{$spot->id}}">
							<td>#{{$spot->id}}</td>
							<td>{{$spot->name}}</td>
							<td>
								<div class="text-muted">
									{{$spot->description}}
								</div>
							</td>
							<td>
									<a href="#" class="label
										{!! $spot->active ? 'label-success' : 'label-danger' !!}">
										{!! $spot->active ? 'Activo' : 'Inactivo' !!}
									</a>
							</td>
							<td>
								<i class="icon-calendar2 position-left"></i>
								{{ $spot->updated_at->format('d M Y H:i')  }}
							</td>
							<td class="text-center">
								<ul class="icons-list">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li>
												<a href="{{ route('admin.spots.edit', [$spot->id]) }}">
													<i class="icon-pencil7"></i> Editar alquilable
												</a>
											</li>
											<li>
												<a href="{{route('admin.spots.destroy', [$spot->id])}}"
												   role="delete-form"
													 data-id="{{$spot->id}}"
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
		</div>
	</div>
</div>
@endsection
