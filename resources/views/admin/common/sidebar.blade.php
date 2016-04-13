<!-- Main sidebar -->
<div class="sidebar sidebar-main">
	<div class="sidebar-content">

		<!-- User menu -->
		<div class="sidebar-user-material">
			<div class="category-content">
				<div class="sidebar-user-material-content">
					<a href="#"><img src="{{$user->avatar()}}" class="img-circle img-responsive" alt=""></a>
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
							<span>Planes</span>
						</a>
					</li>
					<li>
						<a href="{{route('admin.bookables.index')}}" class="legitRipple">
							<i class="icon-stack2"></i>
							Alquilables
						</a>
					</li>
					<li class="navigation-header">
						<span>Configuración</span>
						<i class="icon-menu" title="Configuración"></i>
					</li>
					<li class="">
						<a href="#" class="has-ul legitRipple"><i class="icon-cog"></i> <span>Alquilables</span></a>
						<ul class="hidden-ul" style="display: none;">
							<li><a href="{{route('admin.bookabletypes.index')}}" class="legitRipple">Tipo de alquilable</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<!-- /main navigation -->

	</div>
</div>
<!-- /main sidebar -->