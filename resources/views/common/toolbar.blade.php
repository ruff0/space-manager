{{-- Toolbar --}}
<div class="navbar navbar-default navbar-xs content-group">
	<ul class="nav navbar-nav visible-xs-block">
		<li class="full-width text-center">
			<a data-toggle="collapse" data-target="#navbar-filter">
				<i class="icon-menu7"></i>
			</a>
		</li>
	</ul>

	<div class="navbar-collapse collapse" id="navbar-filter">
		<div class="row">
			<ul class="nav navbar-nav">
				<li>
					<a href="{{route('home')}}" class="legitRipple">
						<img src="/images/logo_dark.png" alt="" height="25">
					</a>
				</li>
			</ul>
			<div class="navbar-right">
			<ul class="nav navbar-nav">
				<li>
					<a href="/home">Inicio</a>
				</li>

				<li>
					<a href="/invoices">Facturación</a>
				</li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-gear"></i>
						<span class="visible-xs-inline-block position-right"> Opciones</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
						@if($user->hasProfile())
							<li>
								<a href="{{route('users.profiles.edit', [$user->id, $user->profile->id])}}">
									<i class="icon-user"></i> Mi perfil
								</a>
							</li>
						@endif
						<li>
							<a href="{{route('members.edit', [$user->member->id])}}">
								<i class="icon-cog5"></i> Mi cuenta
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="{{url('/logout')}}">
								<i class="icon-three-bars"></i> Cerrar sessión
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		</div>
	</div>
</div>
{{-- /toolbar --}}
