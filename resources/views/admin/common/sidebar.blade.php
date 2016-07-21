<!-- Main sidebar -->
<div class="sidebar sidebar-main">
	<div class="sidebar-content">

		<!-- User menu -->
		<div class="sidebar-user-material">
			<div class="category-content">
				<div class="sidebar-user-material-content">
					<a href="#" class="legitRipple">
						<img src="{{$user->avatar(120)}}" class="img-circle img-responsive" alt="{{$user->mail}}" style="background: white;">
					</a>
					<h6>{{$user->name}}</h6>
					<span class="text-size-small">{{$user->email}}</span>
				</div>
			</div>
		</div>
		<!-- /user menu --
		<!-- Main navigation -->
		<div class="sidebar-category sidebar-category-visible">
			<div class="category-content no-padding">
				<ul class="navigation navigation-main navigation-accordion">
					<li>
						<a href="{{ url('/admin') }}" class="legitRipple">
							<i class="icon-home4"></i>
							<span>Dashboard</span>
						</a>
					</li>


					<li class="navigation-header">
						<span>Espacio Coworking</span>
						<i class="icon-menu" title="Espacio Coworking"></i>
					</li>
					<li>
						<a href="{{ route('admin.members.index') }}" class="legitRipple">
							<i class="icon-users4"></i>
							<span>Miembros</span>
						</a>
					</li>

					<li>
						<a href="{{ route('admin.plans.index') }}" class="legitRipple">
							<i class="icon-cash3"></i>
							<span>Alquiler mensual</span>
						</a>
					</li>
					<li>
						<a href="{{route('admin.bookables.index')}}" class="legitRipple">
							<i class="icon-stack2"></i>
							<span>Alquiler diario</span>
						</a>
					</li>

					<li class="navigation-header">
						<span>Reservas de Salas</span>
						<i class="icon-menu" title="Reservas de Salas"></i>
					</li>
					<li>
						<a href="{{route('admin.bookings.calendar')}}" class="legitRipple">
							<i class="icon-stack2"></i>
							<span>Calendario de reservas</span>
						</a>
					</li>
					<li>
						<a href="{{route('admin.bookings.index')}}" class="legitRipple">
							<i class="icon-stack2"></i>
							<span>Salas & Puestos</span>
						</a>
					</li>

					<li class="navigation-header">
						<span>Recursos</span>
						<i class="icon-menu" title="Recursos"></i>
					</li>
					<li class="">
						<a href="#" class="has-ul legitRipple"><i class="icon-stack2"></i> <span>Salas & Puestos</span></a>
						<ul class="hidden-ul" style="display: none;">
							<li>
								<a href="{{route('admin.meetingrooms.index')}}" class="legitRipple">
									<span>Salas de reuniones</span>
								</a>
							</li>
							<li>
								<a href="{{route('admin.classrooms.index')}}" class="legitRipple">
									<span>Aulas</span>
								</a>
							</li>
							<li>
								<a href="{{route('admin.spots.index')}}" class="legitRipple">
									<span>Puestos</span>
								</a>
							</li>
							<li>
								<a href="{{route('admin.offices.index')}}" class="legitRipple">
									<span>Despachos</span>
								</a>
							</li>
						</ul>
					</li>

					<li class="navigation-header">
						<span>Configuración</span>
						<i class="icon-menu" title="Configuración"></i>
					</li>
					<li class="">
						<a href="#" class="has-ul legitRipple"><i class="icon-cog"></i> <span>Alquiler diario</span></a>
						<ul class="hidden-ul" style="display: none;">
							<li><a href="{{route('admin.bookabletypes.index')}}" class="legitRipple">Tipo de alquiler diario</a></li>
						</ul>
					</li>

					<li class="">
						<a href="#" class="has-ul legitRipple"><i class="icon-cog"></i> <span>Alquiler mensual</span></a>
						<ul class="hidden-ul" style="display: none;">
							<li><a href="{{route('admin.plantypes.index')}}" class="legitRipple"><span>Tipo de Suscripciones</span></a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<!-- /main navigation -->

	</div>
</div>
<!-- /main sidebar -->