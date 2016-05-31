@extends('admin.layouts.admin')

@section('body-class', '')

@section('new-form-text', 'Crear nuevo miembro')
@section('new-form-url', route('admin.members.create'))

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
					<h6 class="panel-title">Miembros</h6>
					<div class="heading-elements">
						<ul class="icons-list">
							<li><a data-action="collapse"></a></li>
						</ul>
					</div>
				</div>

				<table class="table members-list table-lg">
					<thead>
					<tr>
						<th>#</th>
						<th>Empresa</th>
						<th>Gerente</th>
						<th>Plan</th>
						<th>Activo</th>
						<th>Última actualización</th>
						<th>Miembro desde</th>
						<th class="text-center text-muted" style="width: 30px;">
							<i class="icon-checkmark3"></i>
						</th>
					</tr>
					</thead>
					<tbody>
					@foreach($members as $member)
						<tr data-plan="{{$member->id}}">
							<td>#{{$member->id}}</td>
							<td>
								<div class="pull-left pr-10">
									<img src="{{$member->avatar()}}" class="img-circle img-xs" alt="{{$member->email}}">
								</div>
								<div class="pull-left pr-10">
									<div class="text-semibold">
										{{ $member->companyName()}}
									</div>
									<div class="text-muted">
										{{ $member->companyIdentity() }}
									</div>
								</div>
							</td>
							<td>
								<div class="pull-left pr-10">
									<img src="{{$member->mainUser()->avatar()}}" class="img-circle img-xs" alt="{{$member->email}}">
								</div>
								<div class="pull-left pr-10">
									<div class="text-semibold">
										{{ $member->mainUser()->fullName()}}
									</div>
									<div class="text-muted">
										{{ $member->email }}
									</div>
								</div>
							</td>
							<td>
								@if($member->currentPlan())
									<span class="text-muted">{{$member->currentPlan()->name}}</span>
								@else
									@inject('plan', 'App\Space\Plan')
									<span class="text-muted">	{{ $plan->byDefault()->name}}</span>
								@endif

							</td>
							<td>
									<a href="#" class="label
										{!! $member->active ? 'label-success' : 'label-danger' !!}">
										{!! $member->active ? 'Activo' : 'Inactivo' !!}
									</a>
							</td>
							<td>
								<i class="icon-calendar2 position-left"></i>
								{{ $member->updated_at->format('d M Y H:i')  }}
							</td>
							<td>
								<i class="icon-calendar2 position-left"></i>
								{{ $member->created_at->format('d M Y H:i')  }}
							</td>
							<td class="text-center">
								<ul class="icons-list">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li>
												<a href="{{route('admin.members.show', [$member->id])}}">
													<i class="icon-eye"></i> Ver miembro
												</a>
											</li>
											<li>
												<a href="{{ route('admin.members.edit', [$member->id]) }}">
													<i class="icon-pencil7"></i> Editar miembro
												</a>
											</li>
											<li>
												<a href="{{route('admin.members.destroy', [$member->id])}}"
												   role="delete-form"
													 data-id="{{$member->id}}"
													 data-token="{{ csrf_token() }}"
												>
													<i class="icon-cross2 position-left"></i>
													Borrar miembro
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
