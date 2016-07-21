@extends('admin.layouts.admin')

@section('body-class', '')

@section('new-form-text', 'Crear despacho')
@section('new-form-url', route('admin.offices.create'))

@section('content')
<div class="page-content">

	@include('admin.common.sidebar')
	<div class="content-wrapper">
		@include('admin.common.header')
		<div class="content pb-20">
			<div class="panel panel-white">
				<div class="panel-heading">
					<h6 class="panel-title">Despachos</h6>
					<div class="heading-elements">
						<ul class="icons-list">
							<li><a data-action="collapse"></a></li>
						</ul>
					</div>
				</div>

				<table class="table offices-list table-lg">
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
					@foreach($offices as $office)
						<tr data-plan="{{$office->id}}">
							<td>#{{$office->id}}</td>
							<td>{{$office->name}}</td>
							<td>
								<div class="text-muted">
									{{$office->description}}
								</div>
							</td>
							<td>
									<a href="#" class="label
										{!! $office->active ? 'label-success' : 'label-danger' !!}">
										{!! $office->active ? 'Activo' : 'Inactivo' !!}
									</a>
							</td>
							<td>
								<i class="icon-calendar2 position-left"></i>
								{{ $office->updated_at->format('d M Y H:i')  }}
							</td>
							<td class="text-center">
								<ul class="icons-list">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li>
												<a href="{{ route('admin.offices.edit', [$office->id]) }}">
													<i class="icon-pencil7"></i> Editar alquilable
												</a>
											</li>
											<li>
												<a href="{{route('admin.offices.destroy', [$office->id])}}"
												   role="delete-form"
													 data-id="{{$office->id}}"
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
