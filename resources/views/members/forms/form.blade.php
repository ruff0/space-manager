{!! csrf_field() !!}
<fieldset>
	<legend>Datos de la Empresa</legend>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-8">
				<label>Razón Social</label>
				<input type="text"
				       placeholder="Mi empresa S.L."
				       class="form-control"
				       name="name"
				       value="{{ old('name', $member->name) }}"
				/>
				@include('forms._validation-error', ['field' => 'name'])
			</div>

			<div class="col-sm-4">
				<label>CIF</label>
				<input type="text"
				       placeholder="00000000N"
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
			<div class="col-sm-6">
				<label>Dirección</label>
				<input type="text"
				       placeholder="c/La Paz 12"
				       class="form-control"
				       name="address_line1"
				       value="{{old('address_line1', $member->address_line1)}}"
				/>
				@include('forms._validation-error', ['field' => 'address_line1'])
			</div>

			<div class="col-sm-6">
				<label>&nbsp;</label>
				<input type="text"
				       placeholder="Bloque 2, 1º Izq."
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
				       placeholder="Alicante"
				       class="form-control"
				       name="city"
				       value="{{old('city', $member->city)}}"
				/>
				@include('forms._validation-error', ['field' => 'city'])
			</div>

			<div class="col-sm-4">
				<label>Provincia</label>
				<input type="text"
				       placeholder="Alicante"
				       class="form-control"
				       name="state"
				       value="{{old('state', $member->state)}}"
				>
				@include('forms._validation-error', ['field' => 'state'])
			</div>

			<div class="col-sm-4">
				<label>Código postal</label>
				<input type="text"
				       placeholder="03001"
				       class="form-control"
				       name="zip"
				       value="{{old('zip', $member->zip)}}"
				/>
				@include('forms._validation-error', ['field' => 'zip'])
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="row">
			<div class="col-sm-6">
				<label>Móvil</label>
				<input type="text"
				       placeholder="965-12-34-56"
				       data-mask="965-12-34-56"
				       class="form-control"
				       name="mobile"
				       value="{{old('mobile', $member->mobile)}}"
				/>
				@include('forms._validation-error', ['field' => 'mobile'])
				{{--<span class="help-block">965-12-34-56</span>--}}
			</div>
			<div class="col-sm-6">
				<label>Télefono</label>
				<input type="text"
				       placeholder="666-12-34-56"
				       data-mask="666-12-34-56"
				       class="form-control"
				       name="phone"
				       value="{{old('phone', $member->phone)}}"
				/>
				@include('forms._validation-error', ['field' => 'phone'])
				{{--<span class="help-block">666-12-34-56</span>--}}
			</div>
		</div>
	</div>
</fieldset>

{{--<fieldset>--}}
{{--<legend>Datos de la empresa</legend>--}}
{{--<div class="form-group">--}}
{{--<div class="row">--}}
{{--<div class="col-sm-8">--}}
{{--<label>Razón Sócial</label>--}}
{{--<input type="text"--}}
{{--placeholder="Mi mega empresa S.L."--}}
{{--class="form-control"--}}
{{--name="company[name]"--}}
{{--value="{{old('company[name]')}}"--}}
{{-->--}}
{{--@include('forms._validation-error', ['field' => 'company[name]'])--}}
{{--</div>--}}

{{--<div class="col-sm-4">--}}
{{--<label>CIF</label>--}}
{{--<input type="text"--}}
{{--placeholder="B00000000N"--}}
{{--class="form-control"--}}
{{--name="company[id]"--}}
{{--value="{{old('company[id]')}}"--}}
{{--/>--}}
{{--@include('forms._validation-error', ['field' => 'company[id]'])--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</fieldset>--}}