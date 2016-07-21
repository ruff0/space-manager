{{--{!! dd(app('request')) !!}}--}}
<form action="{{ url('/login?form=login') }}" role="form" method="POST">
	{!! csrf_field() !!}
	<div class="text-center">
		<div class="icon-object border-warning text-warning">
			<i class="icon-lock2"></i>
		</div>
		<h5 class="content-group">Enter the community
			<small class="display-block"></small>
		</h5>
	</div>

	<div class="form-group has-feedback has-feedback-left">
		<input type="text"
		       class="form-control"
		       placeholder="Email"
		       name="email"
		       required="required"
		       @if(old('form') != 'register') value="{{ old('email') }}" @endif
		/>
		<div class="form-control-feedback">
			<i class="icon-user text-muted"></i>
		</div>
		@if(old('form') != 'register')	@include('forms._validation-error', ['field' => 'email']) @endif
	</div>

	<div class="form-group has-feedback has-feedback-left">
		<input type="password"
		       class="form-control"
		       placeholder="Password"
		       name="password"
		       required="required"
		/>
		<div class="form-control-feedback">
			<i class="icon-lock2 text-muted"></i>
		</div>
		@if(old('form') != 'register') 	@include('forms._validation-error', ['field' => 'password']) @endif
	</div>

	<div class="form-group login-options">
		<div class="row">
			<div class="col-sm-6">
				<label class="checkbox-inline">
					<input type="checkbox"
					       class="styled"
					       checked="checked"
					       name="remember"
					/>
					Recuérdame
				</label>
			</div>

			<div class="col-sm-6 text-right">
				<a href="{{ url('/password/reset') }}">He olvidado mi contraseña?</a>
			</div>
		</div>
	</div>

	<div class="form-group">
		<button type="submit" class="btn btn-warning btn-block">Login <i
				class="icon-arrow-right14 position-right"></i></button>
	</div>
</form>