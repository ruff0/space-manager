{!! csrf_field() !!}

<div class="form-group">
	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Nombre</label>
			<input type="text"
			       placeholder="El nombre del aula"
			       class="form-control"
			       name="name"
			       value="{{ old('name', $classroom->name) }}"
			/>
			@include('forms._validation-error', ['field' => 'name'])
		</div>
	</div>
	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Descripción</label>
			<textarea
			       placeholder="Aquí puedes describir brevemente este aula"
			       class="form-control"
			       name="description"
			>{{ old('description', $classroom->description) }}</textarea>
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
			       value="{{ old('max_occupants', $classroom->max_occupants) }}"
			/>
			@include('forms._validation-error', ['field' => 'max_occupants'])
		</div>
		<div class="col-sm-6">
			<label>Metros cuadrados</label>
			<input type="number"
			       placeholder="Los metros cuadrados"
			       class="form-control"
			       name="floor"
			       value="{{ old('floor', $classroom->floor) }}"
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
					{!! $classroom->active || old('active')? 'checked' : null !!}
				/>
					<span class="text-muted">
						Este aula esta activo o inactivo
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
					{!! $classroom->isResource() || old('create_resource')? 'checked' : null !!}
				/>
					<span class="text-muted">
						Quieres que este aula de reuniones se pueda usar como recurso?
					</span>
				</label>
			</div>
			@include('forms._validation-error', ['field' => 'create_resource'])
		</div>
	</div>
</div>
