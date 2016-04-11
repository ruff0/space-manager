{!! csrf_field() !!}

<div class="form-group">
	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Nombre</label>
			<input type="text"
			       placeholder="El nombre del tamaño de sala"
			       class="form-control"
			       name="name"
			       value="{{ old('name', $bookablesize->name) }}"
			/>
			@include('forms._validation-error', ['field' => 'name'])
		</div>
	</div>

	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Descripción</label>
			<textarea
			       placeholder="Aquí puedes describir brevemente el tamaño de sala"
			       class="form-control"
			       name="description"
			>{{ old('description', $bookablesize->description) }}</textarea>
			@include('forms._validation-error', ['field' => 'description'])
		</div>
	</div>

	<div class="row pb-20">
		<div class="col-sm-6">
			<label>Ocupantes</label>
			<input type="number"
			       placeholder="La cantidad máxima de ocupantes en la sala"
			       class="form-control"
			       name="max_occupants"
			       value="{{ old('max_occupants', $bookablesize->max_occupants) }}"
			/>
			@include('forms._validation-error', ['field' => 'max_occupants'])
		</div>
		<div class="col-sm-6">
			<label>Metros cuadrados</label>
			<input type="number"
			       placeholder="Los metros cuadrados de la sala"
			       class="form-control"
			       name="floor"
			       value="{{ old('floor', $bookablesize->floor) }}"
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
					{!! $bookablesize->active || old('active')? 'checked' : null !!}
				/>
					<span class="text-muted">
						Este tipo de sala esta activo o inactivo
					</span>
				</label>
			</div>
			@include('forms._validation-error', ['field' => 'active'])
		</div>
	</div>
</div>
