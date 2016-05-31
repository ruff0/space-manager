{!! csrf_field() !!}

<div class="form-group">
	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Nombre</label>
			<input type="text"
			       placeholder="El nombre del tipo de suscripción"
			       class="form-control"
			       name="name"
			       value="{{ old('name', $plantype->name) }}"
			/>
			@include('forms._validation-error', ['field' => 'name'])
		</div>
	</div>

	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Descripción</label>
			<textarea
			       placeholder="Aquí puedes describir brevemente el tipo de suscripción"
			       class="form-control"
			       name="description"
			>{{ old('description', $plantype->description) }}</textarea>
			@include('forms._validation-error', ['field' => 'description'])
		</div>
	</div>

	<div class="row pb-20">
		<div class="col-sm-12">
			@include('forms.images', ['entity' => $plantype])
		</div>
	</div>


	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Activo</label>
			<div class="checkbox checkbox-switchery">
				<label for="active">
				<input name="active" id="active" type="checkbox" class="switchery" value="1"
					{!! $plantype->active || old('active')? 'checked' : null !!}
				/>
					<span class="text-muted">
						Este tipo de suscripción esta activo o inactivo
					</span>
				</label>
			</div>
			@include('forms._validation-error', ['field' => 'active'])
		</div>
	</div>

	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Seleccionable</label>
			<div class="checkbox checkbox-switchery">
				<label for="show">
				<input name="show" id="show" type="checkbox" class="switchery" value="1"
					{!! $plantype->show || old('show')? 'checked' : null !!}
				/>
					<span class="text-muted">
						Se debe de mostrar este tipo de plan para el usuario?
					</span>
				</label>
			</div>
			@include('forms._validation-error', ['field' => 'show'])
		</div>
	</div>
</div>
