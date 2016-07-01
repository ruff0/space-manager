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
				<div class="panel-heading">
					<h6 class="panel-title">Alquileres</h6>
					<div class="heading-elements">
						<ul class="icons-list">
							<li><a data-action="collapse"></a></li>
						</ul>
					</div>
				</div>

				<table class="table bookings-list table-lg">
					<thead>
					<tr>
						<th>#</th>
						<th>Mes</th>
						<th>Nombre</th>
						<th>Sala</th>
						<th>Fecha de la Reserva</th>
						<th>Pagado</th>
						<th>Ultima actualización</th>
						<th class="text-center text-muted" style="width: 30px;">
							<i class="icon-checkmark3"></i>
						</th>
					</tr>
					</thead>
					<tbody>
					@foreach($bookings as $booking)
						<tr data-plan="{{$booking->id}}">
							<td>#{{$booking->id}}</td>
							<td>{{$booking->time_from->format('Y F')}}</td>
							<td>{{$booking->member->fullname()}}</td>
							<td>
								{{$booking->resource->resourceable->name}}  <br>
								<span class="text-muted">
									{{$booking->bookable->name}}
								</span>
							</td>
							<td>
								<div class="text-muted">
									{{$booking->time_from->format('j M \d\e Y')}}
									( {{$booking->time_from->diffInHours($booking->time_to) }} horas)
									<br>
									desde : {{$booking->time_from->format('H:i')}} -
									hasta : {{$booking->time_to->format('H:i')}}
								</div>
							</td>
							<td>
									<a href="#" class="label
										{!! $booking->isPaid() ? 'label-success' : 'label-danger' !!}">
										{!! $booking->isPaid() ? 'Pagado' : 'Sin Pagar' !!}
									</a>
							</td>
							<td>
								<i class="icon-calendar2 position-left"></i>
								{{ $booking->updated_at->format('d M Y H:i')  }}
							</td>
							<td class="text-center">
								<ul class="icons-list">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
											@if($booking->isPaid())
											<li>
												<a href="{{ route('admin.bookings.edit', [$booking->id]) }}">
													<i class="icon-eye2"></i> Ver
												</a>
											</li>
											@endif

											@if(!$booking->isPaid())
											<li>
												<a href="{{ route('admin.bookings.edit', [$booking->id]) }}">
													<i class="icon-pencil7"></i> Editar
												</a>
											</li>

												<li>
													<a href="{{route('admin.bookings.destroy', [$booking->id])}}"
													   role="delete-form"
														 data-id="{{$booking->id}}"
														 data-token="{{ csrf_token() }}"
													>
														<i class="icon-cross2 position-left"></i>
														Cancelar
													</a>
												</li>
											@endif
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
