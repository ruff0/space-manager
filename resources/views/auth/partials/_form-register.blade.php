<form action="{{ url('/register?form=register') }}" method="POST">
	{!! csrf_field() !!}
	<div class="text-center">
		<div class="icon-object border-warning text-warning">
			<i class="icon-pencil6"></i>
		</div>
		<h5 class="content-group">Crea tu cuenta
			<small class="display-block">
				Todos los campos son obligatorios
			</small>
		</h5>
	</div>

	<div class="form-group has-feedback has-feedback-left">
		<input type="text"
		       class="form-control"
		       placeholder="Tu nombre de usuario"
		       name="name"
		       @if(old('form') == 'register') value="{{ old('name') }}" @endif
		/>
		<div class="form-control-feedback">
			<i class="icon-user-check text-muted"></i>
		</div>
		@if(old('form') == 'register') @include('forms._validation-error', ['field' => 'name']) @endif
	</div>
	<div class="form-group has-feedback has-feedback-left">
		<input type="text"
		       class="form-control"
		       placeholder="Tu email"
		       name="email"
		       @if(old('form') == 'register') value="{{ old('email') }}" @endif
		/>
		<div class="form-control-feedback">
			<i class="icon-mention text-muted"></i>
		</div>
		@if(old('form') == 'register') 	@include('forms._validation-error', ['field' => 'email']) @endif
	</div>

	<div class="form-group has-feedback has-feedback-left">
		<input type="password"
		       class="form-control"
		       placeholder="Tu password"
		       name="password"
		/>
		<div class="form-control-feedback">
			<i class="icon-user-lock text-muted"></i>
		</div>
		@if(old('form') == 'register') @include('forms._validation-error', ['field' => 'password']) @endif
	</div>

	<div class="form-group has-feedback has-feedback-left">
		<input type="password"
		       class="form-control"
		       placeholder="Confirma tu password"
		       name="password_confirmation"
		/>
		<div class="form-control-feedback">
			<i class="icon-user-lock text-muted"></i>
		</div>
		@if(old('form') == 'register') @include('forms._validation-error', ['field' => 'password_confirmation']) @endif
	</div>



	{{--<div class="content-divider text-muted form-group"><span>Additions</span></div>--}}

	<div class="form-group">
		<div class="checkbox">
			<label>
				<input type="checkbox" class="styled" checked="checked">
				Suscríbeme a la newsletter mensual
			</label>
		</div>

		<div class="checkbox">
			<label>
				<input type="checkbox" class="styled" name="conditions">
				Acepto <a href="#">los términos y condiciones del servicio</a>
			</label>
		</div>
	</div>

	<button type="submit" class="btn btn-warning btn-block" name="register">Regístrame <i
			class="icon-circle-right2 position-right"></i></button>
</form>