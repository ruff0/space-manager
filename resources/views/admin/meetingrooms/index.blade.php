@extends('admin.layouts.admin')

@section('body-class', '')

@section('new-form-text', 'Crear sala de reuniones')
@section('new-form-url', route('admin.meetingrooms.create'))

@section('content')
<div class="page-content">

	@include('admin.common.sidebar')
	<div class="content-wrapper">
		@include('admin.common.header')
		<div class="content pb-20">
			<div class="panel panel-white">
				<div class="panel-heading">
					<h6 class="panel-title">Salas de reuniones</h6>
					<div class="heading-elements">
						<ul class="icons-list">
							<li><a data-action="collapse"></a></li>
						</ul>
					</div>
				</div>

				<table class="table meetingrooms-list table-lg">
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
					@foreach($meetingrooms as $meetingroom)
						<tr data-plan="{{$meetingroom->id}}">
							<td>#{{$meetingroom->id}}</td>
							<td>{{$meetingroom->name}}</td>
							<td>
								<div class="text-muted">
									{{$meetingroom->description}}
								</div>
							</td>
							<td>
									<a href="#" class="label
										{!! $meetingroom->active ? 'label-success' : 'label-danger' !!}">
										{!! $meetingroom->active ? 'Activo' : 'Inactivo' !!}
									</a>
							</td>
							<td>
								<i class="icon-calendar2 position-left"></i>
								{{ $meetingroom->updated_at->format('d M Y H:i')  }}
							</td>
							<td class="text-center">
								<ul class="icons-list">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li>
												<a href="{{ route('admin.meetingrooms.edit', [$meetingroom->id]) }}">
													<i class="icon-pencil7"></i> Editar alquilable
												</a>
											</li>
											<li>
												<a href="{{route('admin.meetingrooms.destroy', [$meetingroom->id])}}"
												   role="delete-form"
													 data-id="{{$meetingroom->id}}"
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
