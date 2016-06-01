{!! csrf_field() !!}
<fieldset>
	<legend>Datos personales</legend>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-4">
				<label>Nombre</label>
				<input type="text"
				       placeholder=""
				       class="form-control"
				       name="name"
				       value="{{ old('name', $member->name) }}"
				/>
				@include('forms._validation-error', ['field' => 'name'])
			</div>

			<div class="col-sm-4">
				<label>Apellidos</label>
				<input type="text"
				       placeholder=""
				       class="form-control"
				       name="lastname"
				       value="{{old('lastname', $member->lastname)}}"
				/>
				@include('forms._validation-error', ['field' => 'lastname'])
			</div>

			<div class="col-sm-4">
				<label>NIF / NIE</label>
				<input type="text"
				       placeholder=""
				       class="form-control"
				       name="identity"
				       value="{{old('identity', $member->identity)}}"
				/>
				@include('forms._validation-error', ['field' => 'identity'])
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-4">
				<label>Email</label>
				<input type="email"
				       placeholder=""
				       class="form-control"
				       name="email"
				       value="{{old('email', $member->email?:$user->email)}}"
				/>
				@include('forms._validation-error', ['field' => 'email'])
			</div>

			<div class="col-sm-4">
				<label>Móvil</label>
				<input type="text"
				       placeholder=""
				       class="form-control"
				       name="mobile"
				       value="{{old('mobile', $member->mobile)}}"
				/>
				@include('forms._validation-error', ['field' => 'mobile'])
			</div>

			<div class="col-sm-4">
				<label>Télefono</label>
				<input type="text"
				       placeholder=""
				       class="form-control"
				       name="phone"
				       value="{{old('phone', $member->phone)}}"
				/>
				@include('forms._validation-error', ['field' => 'phone'])
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-6">
				<label>Dirección</label>
				<input type="text"
				       placeholder=""
				       class="form-control"
				       name="address_line1"
				       value="{{old('address_line1', $member->address_line1)}}"
				/>
				@include('forms._validation-error', ['field' => 'address_line1'])
			</div>

			<div class="col-sm-6">
				<label>&nbsp;</label>
				<input type="text"
				       placeholder=""
				       class="form-control"
				       name="address_line2"
				       value="{{old('address_line2', $member->address_line2)}}"
				/>
				@include('forms._validation-error', ['field' => 'address_line2'])
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="row">
			<div class="col-sm-4">
				<label>Ciudad</label>
				<input type="text"
				       placeholder=""
				       class="form-control"
				       name="city"
				       value="{{old('city', $member->city)}}"
				/>
				@include('forms._validation-error', ['field' => 'city'])
			</div>

			<div class="col-sm-4">
				<label>Provincia</label>
				<input type="text"
				       placeholder=""
				       class="form-control"
				       name="state"
				       value="{{old('state', $member->state)}}"
				>
				@include('forms._validation-error', ['field' => 'state'])
			</div>

			<div class="col-sm-4">
				<label>Código postal</label>
				<input type="text"
				       placeholder=""
				       class="form-control"
				       name="zip"
				       value="{{old('zip', $member->zip)}}"
				/>
				@include('forms._validation-error', ['field' => 'zip'])
			</div>
		</div>
	</div>
</fieldset>
<fieldset>
	<legend>Datos de la empresa</legend>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-8">
				<label>Razón Sócial</label>
				<input type="text"
				       placeholder=""
				       class="form-control"
				       name="company_name"
				       value="{{old('company_name', $member->company_name ?: '')}}"
				>
				@include('forms._validation-error', ['field' => 'company_name'])
			</div>

			<div class="col-sm-4">
				<label>CIF</label>
				<input type="text"
				       placeholder=""
				       class="form-control"
				       name="company_identity"
				       value="{{old('company_identity', $member->company_identity ?: '')}}"
				/>
				@include('forms._validation-error', ['field' => 'company_identity'])
			</div>
		</div>
	</div>
</fieldset>