{!! csrf_field() !!}
<fieldset>
	<legend>Datos personales</legend>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-6">
				<label>Nombre</label>
				<input type="text"
				       placeholder="Antonio"
				       class="form-control"
				       name="name"
				       value="{{ old('name', $profile->name) }}"
				/>
				@include('forms._validation-error', ['field' => 'name'])
			</div>

			<div class="col-sm-6">
				<label>Apellidos</label>
				<input type="text"
				       placeholder="Gómez Pérez"
				       class="form-control"
				       name="lastname"
				       value="{{old('lastname', $profile->lastname)}}"
				/>
				@include('forms._validation-error', ['field' => 'lastname'])
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-6">
				<label>Email</label>
				<input type="email"
				       placeholder="usuario@email.com"
				       class="form-control"
				       name="email"
				       value="{{old('email', $profile->email?:$user->email)}}"
				/>
				@include('forms._validation-error', ['field' => 'email'])
			</div>

			<div class="col-sm-6">
				<label>Móvil</label>
				<input type="text"
				       placeholder="965-12-34-56"
				       data-mask="965-12-34-56"
				       class="form-control"
				       name="mobile"
				       value="{{old('mobile', $profile->mobile)}}"
				/>
				@include('forms._validation-error', ['field' => 'mobile'])
			</div>
		</div>
	</div>
</fieldset>