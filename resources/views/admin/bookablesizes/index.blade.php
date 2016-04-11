@extends('admin.layouts.admin')

@section('body-class', '')

@section('new-form-text', 'Crear nuevo tamaño de sala')
@section('new-form-url', route('admin.bookablesizes.create'))

@section('content')
<div class="page-content">

	@include('admin.common.sidebar')
	<div class="content-wrapper">
		@include('admin.common.header')
		<div class="content pb-20">
			<div class="panel panel-white">
				<div class="panel-heading">
					<h6 class="panel-title">Tamaños de Sala</h6>
					<div class="heading-elements">
						<ul class="icons-list">
							<li><a data-action="collapse"></a></li>
						</ul>
					</div>
				</div>

				<table class="table bookablesizes-list table-lg">
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
					@foreach($bookablesizes as $bookablesize)
						<tr data-plan="{{$bookablesize->id}}">
							<td>#{{$bookablesize->id}}</td>
							<td>{{$bookablesize->name}}</td>
							<td>
								<div class="text-muted">
									{{$bookablesize->description}}
								</div>
							</td>
							<td>
									<a href="#" class="label
										{!! $bookablesize->active ? 'label-success' : 'label-danger' !!}">
										{!! $bookablesize->active ? 'Activo' : 'Inactivo' !!}
									</a>
							</td>
							<td>
								<i class="icon-calendar2 position-left"></i>
								{{ $bookablesize->updated_at->format('d M Y H:i')  }}
							</td>
							<td class="text-center">
								<ul class="icons-list">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li>
												<a href="{{ route('admin.bookablesizes.edit', [$bookablesize->id]) }}">
													<i class="icon-pencil7"></i> Editar tipo de sala
												</a>
											</li>
											<li>
												<a href="{{route('admin.bookablesizes.destroy', [$bookablesize->id])}}"
												   role="delete-form"
													 data-id="{{$bookablesize->id}}"
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
