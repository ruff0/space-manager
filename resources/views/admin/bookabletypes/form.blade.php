{!! csrf_field() !!}

<div class="form-group">
	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Nombre</label>
			<input type="text"
			       placeholder="El nombre del tipo de sala"
			       class="form-control"
			       name="name"
			       value="{{ old('name', $bookabletype->name) }}"
			/>
			@include('forms._validation-error', ['field' => 'name'])
		</div>
	</div>

	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Descripción</label>
			<textarea
			       placeholder="Aquí puedes describir brevemente el tipo de sala"
			       class="form-control"
			       name="description"
			>{{ old('description', $bookabletype->description) }}</textarea>
			@include('forms._validation-error', ['field' => 'description'])
		</div>
	</div>

	<div class="row pb-20">
		<div class="col-sm-12">
			@include('forms.images', ['entity' => $bookabletype])
		</div>
	</div>

	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Activo</label>
			<div class="checkbox checkbox-switchery">
				<label for="active">
				<input name="active" id="active" type="checkbox" class="switchery" value="1"
					{!! $bookabletype->active || old('active')? 'checked' : null !!}
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
