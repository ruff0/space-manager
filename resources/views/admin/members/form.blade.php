{!! csrf_field() !!}
<div class="form-group">
	<fieldset>
		<legend>Datos Personales</legend>

		<div class="row pb-20">
			<div class="col-sm-4">
				<label>Nombre</label>
				<input type="text"
				       placeholder="Juan Antonio"
				       class="form-control"
				       name="name"
				       value="{{ old('name', $member->name) }}"
				/>
				@include('forms._validation-error', ['field' => 'name'])
			</div>

			<div class="col-sm-4">
				<label>Apellidos</label>
				<input type="text"
				       placeholder="Perez Gomez"
				       class="form-control"
				       name="lastname"
				       value="{{ old('lastname', $member->lastname) }}"
				/>
				@include('forms._validation-error', ['field' => 'lastname'])
			</div>
			<div class="col-sm-4">
				<label>NIF / NIE</label>
				<input type="text"
				       placeholder="00000000N"
				       class="form-control"
				       name="identity"
				       value="{{ old('identity', $member->identity) }}"
				/>
				@include('forms._validation-error', ['field' => 'identity'])
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend>Datos de contacto</legend>
		<div class="row pb-20">
			<div class="col-sm-4">
				<label>Email</label>
				<input type="email"
				       placeholder="user@email.com"
				       class="form-control"
				       name="email"
				       value="{{ old('email', $member->email) }}"
				/>
				@include('forms._validation-error', ['field' => 'email'])
			</div>

			<div class="col-sm-4">
				<label>Télefono</label>
				<input type="text"
				       placeholder="965123456"
				       class="form-control"
				       name="phone"
				       value="{{ old('phone', $member->phone) }}"
				/>
				@include('forms._validation-error', ['field' => 'phone'])
			</div>

			<div class="col-sm-4">
				<label>Móvil</label>
				<input type="text"
				       placeholder="600123456"
				       class="form-control"
				       name="mobile"
				       value="{{ old('mobile', $member->mobile) }}"
				/>
				@include('forms._validation-error', ['field' => 'mobile'])
			</div>
		</div>
	</fieldset>
	<fieldset>
		<legend>Dirección</legend>
		<div class="row pb-20">
			<div class="col-sm-6">
				<label>Dirección</label>
				<input type="text"
				       placeholder="c/ Castaños 1"
				       class="form-control"
				       name="address_line1"
				       value="{{ old('address_line1', $member->address_line1) }}"
				/>
				@include('forms._validation-error', ['field' => 'address_line1'])
			</div>

			<div class="col-sm-6">
				<label>&nbsp;</label>
				<input type="text"
				       placeholder="2º Puerta C"
				       class="form-control"
				       name="address_line2"
				       value="{{ old('address_line2', $member->address_line2) }}"
				/>
				@include('forms._validation-error', ['field' => 'address_line2'])
			</div>
		</div>


		<div class="row pb-20">
			<div class="col-sm-4">
				<label>Provincia</label>
				<input type="text"
				       placeholder="Alicante"
				       class="form-control"
				       name="state"
				       value="{{ old('state', $member->state) }}"
				/>
				@include('forms._validation-error', ['field' => 'state'])
			</div>

			<div class="col-sm-4">
				<label>Ciudad</label>
				<input type="text"
				       placeholder="Alicante"
				       class="form-control"
				       name="city"
				       value="{{ old('city', $member->city) }}"
				/>
				@include('forms._validation-error', ['field' => 'city'])
			</div>

			<div class="col-sm-4">
				<label>Código postal</label>
				<input type="text"
				       placeholder="03001"
				       class="form-control"
				       name="zip"
				       value="{{ old('zip', $member->zip) }}"
				/>
				@include('forms._validation-error', ['field' => 'zip'])
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend>Datos de la empresa</legend>
		<div class="row pb-20">
			<div class="col-sm-6">
				<label>Razón social</label>
				<input type="text"
				       placeholder="Mi Empresa S.L."
				       class="form-control"
				       name="company_name"
				       value="{{ old('company_name', $member->company_name) }}"
				/>
				@include('forms._validation-error', ['field' => 'company_name'])
			</div>

			<div class="col-sm-6">
				<label>CIF</label>
				<input type="text"
				       placeholder="B00000000N"
				       class="form-control"
				       name="company_identity"
				       value="{{ old('company_identity', $member->company_identity) }}"
				/>
				@include('forms._validation-error', ['field' => 'company_identity'])
			</div>
		</div>
</fieldset>
<div class="row pb-20">
	<div class="col-sm-12">
		<label>Enviar email de activación</label>
		<div class="checkbox checkbox-switchery">
			<label for="send-details-by-mail">
				<input name="send-details-by-mail" id="send-details-by-mail" type="checkbox" class="switchery"
				       checked disabled
				/>
					<span class="text-muted">
						Enviarle los datos de acceso al email del usuario
					</span>
			</label>
		</div>
		@include('forms._validation-error', ['field' => 'send-details-by-mail'])
	</div>
</div>
</div>
