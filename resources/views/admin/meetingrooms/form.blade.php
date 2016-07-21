{!! csrf_field() !!}

<div class="form-group">
	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Nombre</label>
			<input type="text"
			       placeholder="El nombre de la sala de reuniones"
			       class="form-control"
			       name="name"
			       value="{{ old('name', $meetingroom->name) }}"
			/>
			@include('forms._validation-error', ['field' => 'name'])
		</div>
	</div>
	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Descripción</label>
			<textarea
			       placeholder="Aquí puedes describir brevemente esta sala de reuniones"
			       class="form-control"
			       name="description"
			>{{ old('description', $meetingroom->description) }}</textarea>
			@include('forms._validation-error', ['field' => 'description'])
		</div>
	</div>

	<div class="row pb-20">
		<div class="col-sm-6">
			<label>Ocupantes</label>
			<input type="number"
			       placeholder="La cantidad máxima de ocupantes"
			       class="form-control"
			       name="max_occupants"
			       value="{{ old('max_occupants', $meetingroom->max_occupants) }}"
			/>
			@include('forms._validation-error', ['field' => 'max_occupants'])
		</div>
		<div class="col-sm-6">
			<label>Metros cuadrados</label>
			<input type="number"
			       placeholder="Los metros cuadrados"
			       class="form-control"
			       name="floor"
			       value="{{ old('floor', $meetingroom->floor) }}"
			/>
			@include('forms._validation-error', ['field' => 'floor'])
		</div>
	</div>

	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Activo</label>
			<div class="checkbox checkbox-switchery">
				<label for="active">
				<input name="active" id="active" type="checkbox" class="switchery" value="1"
					{!! $meetingroom->active || old('active')? 'checked' : null !!}
				/>
					<span class="text-muted">
						Este alquilable esta activo o inactivo
					</span>
				</label>
			</div>
			@include('forms._validation-error', ['field' => 'active'])
		</div>
	</div>

	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Usar como recurso</label>
			<div class="checkbox checkbox-switchery">
				<label for="create_resource">
				<input name="create_resource" type="hidden" value="0"/>
				<input name="create_resource" id="create_resource" type="checkbox" class="switchery" value="1"
					{!! $meetingroom->isResource() || old('create_resource')? 'checked' : null !!}
				/>
					<span class="text-muted">
						Quieres que esta sala de reuniones se pueda usar como recurso?
					</span>
				</label>
			</div>
			@include('forms._validation-error', ['field' => 'create_resource'])
		</div>
	</div>
</div>
