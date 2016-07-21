{!! csrf_field() !!}

<div class="form-group">
	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Nombre del plan</label>
			<input type="text"
			       placeholder="El nombre del plan"
			       class="form-control"
			       name="name"
			       value="{{ old('name', $plan->name) }}"
			/>
			@include('forms._validation-error', ['field' => 'name'])
		</div>
	</div>
	<div class="row pb-20">
		<div class="col-sm-12">
			@inject('types', 'App\Space\PlanType')
			<label>Tipo de selectable</label>
			<select name="plan_type_id" data-placeholder="Selecciona un tipo" class="select">
				<option></option>
				@foreach($types->actives() as $type)

					<option value="{{$type->id}}"
					        @if($plan->hasType($type)) selected @endif
					>
						{{$type->name}}
					</option>
				@endforeach
			</select>
			@include('forms._validation-error', ['field' => 'plan_type_id'])
		</div>
	</div>

	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Descripción</label>
			<input type="textarea"
			       placeholder="Aquí puedes describir brevemente el plan"
			       class="form-control"
			       name="description"
			       value="{{ old('description', $plan->description) }}"
			/>
			@include('forms._validation-error', ['field' => 'description'])
		</div>
	</div>

	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Precio</label>
			<input type="text"
			       placeholder="1000"
			       class="form-control"
			       name="price"
			       value="{{ old('price', $plan->price) }}"
			       {!! $plan->exists ? 'disabled' : ''  !!}
			/>
			@include('forms._validation-error', ['field' => 'price'])
		</div>
	</div>


	<div class="row pb-20">
		<div class="col-sm-12">
			@include('forms.images', ['entity' => $plan])
		</div>
	</div>

	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Activo</label>
			<div class="checkbox checkbox-switchery">
				<label for="active">
				<input name="active" value="1" id="active" type="checkbox" class="switchery"
					{!! $plan->active || old('active')? 'checked' : null !!}
				/>
					<span class="text-muted">
						Este plan esta activo o inactivo
					</span>
				</label>
			</div>
			@include('forms._validation-error', ['field' => 'active'])
		</div>
	</div>
	{{--{{dd($errors)}}--}}
	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Plan es standalone</label>
			<div class="checkbox checkbox-switchery">
				<label for="standalone">
				<input name="standalone" value="1" id="standalone" type="checkbox" class="switchery"
					{!! $plan->standalone || old('standalone')? 'checked' : null !!}
				/>
					<span class="text-muted">
						Este es el plan que se le aplica por defecto a un usuario nuevo
					</span>
				</label>
			</div>
			@include('forms._validation-error', ['field' => 'standalone'])
		</div>
	</div>

	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Plan es por defecto</label>
			<div class="checkbox checkbox-switchery">
				<label for="default">
				<input name="default" value="1" id="default" type="checkbox" class="switchery"
					{!! $plan->default || old('default')? 'checked' : null !!}
				/>
					<span class="text-muted">
						Este plan se puede contratar solo o es un adjunto a otro plan
					</span>
				</label>
			</div>
			@include('forms._validation-error', ['field' => 'default'])
		</div>
	</div>

	<fieldset>
		<legend>Descuentos</legend>
		<div class="row pb-20">
			<div class="col-sm-4 col-lg-4">
				<label>Planes</label>
				<div class="input-group">
					<input type="text"
					       placeholder="10"
					       class="form-control"
					       name="discounts[plans]"
					       value="{{ old('discounts[plans]',  isset($plan->discounts["plans"]) ?$plan->discounts["plans"]: '') }}"
					/>
					<span class="input-group-addon"><i class="icon-percent"></i></span>
				</div>
				@include('forms._validation-error', ['field' => 'discounts.plans'])
			</div>
			<div class="col-sm-4 col-lg-4">
				<label>Alquiler de salas</label>
				<div class="input-group">
					<input type="text"
					       placeholder="10"
					       class="form-control"
					       name="discounts[bookings]"
					       value="{{ old('discounts[bookings]', isset($plan->discounts["bookings"]) ?$plan->discounts["bookings"]: '') }}"
					/>
					<span class="input-group-addon"><i class="icon-percent"></i></span>
				</div>
				@include('forms._validation-error', ['field' => 'discounts.bookings'])
			</div>
			<div class="col-sm-4 col-lg-4">
				<label>Eventos</label>
				<div class="input-group">
					<input type="text"
					       placeholder="10"
					       class="form-control"
					       name="discounts[events]"
					       value="{{ old('discounts[events]', isset($plan->discounts["events"]) ?$plan->discounts["events"]: '') }}"
					/>
					<span class="input-group-addon"><i class="icon-percent"></i></span>
				</div>
				@include('forms._validation-error', ['field' => 'discounts.events'])
			</div>
		</div>
	</fieldset>

</div>
