{!! csrf_field() !!}
{{--<input type="hidden" name="resources[]" value="1">--}}
<div class="form-group">
	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Nombre</label>
			<input type="text"
			       placeholder="El nombre del alquilable"
			       class="form-control"
			       name="name"
			       value="{{ old('name', $bookable->name) }}"
			/>
			@include('forms._validation-error', ['field' => 'name'])
		</div>
	</div>

	<div class="row pb-20">
		<div class="col-sm-12">
			@inject('types', 'App\Bookables\BookableType')
			<label>Tipo de selectable</label>
			<select name="bookable_type_id" data-placeholder="Selecciona un tipo" class="select">
				<option></option>
				@foreach($types->actives() as $type)

					<option value="{{$type->id}}"
									@if($bookable->hasType($type)) selected @endif
					>
						{{$type->name}}
					</option>
				@endforeach
			</select>
			@include('forms._validation-error', ['field' => 'bookable_type_id'])
		</div>
	</div>

	<div class="row pb-20">
		<div class="col-sm-12">
			<label>Descripción</label>
			<textarea
			       placeholder="Aquí puedes describir brevemente este alquilable"
			       class="form-control"
			       name="description"
			>{{ old('description', $bookable->description) }}</textarea>
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
			       value="{{ old('max_occupants', $bookable->max_occupants) }}"
			/>
			@include('forms._validation-error', ['field' => 'max_occupants'])
		</div>
		<div class="col-sm-6">
			<label>Metros cuadrados</label>
			<input type="number"
			       placeholder="Los metros cuadrados"
			       class="form-control"
			       name="floor"
			       value="{{ old('floor', $bookable->floor) }}"
			/>
			@include('forms._validation-error', ['field' => 'floor'])
		</div>
	</div>

	<div class="row pb-20">
		<div class="col-sm-12">
			@include('forms.images', ['entity' => $bookable])
		</div>
	</div>
	<div class="row pb-20">
		<div class="col-sm-6">
			<label>Activo</label>
			<div class="checkbox checkbox-switchery">
				<label for="active">
				<input name="active" id="active" type="checkbox" class="switchery" value="1"
					{!! $bookable->active || old('active')? 'checked' : null !!}
				/>
					<span class="text-muted">
						Este alquilable esta activo o inactivo
					</span>
				</label>
			</div>
			@include('forms._validation-error', ['field' => 'active'])
		</div>

		<div class="col-sm-6">
			<label>Mostrar con IVA</label>
			<div class="checkbox checkbox-switchery">
				<label for="show_vat">
				<input name="show_vat" id="show_vat" type="checkbox" class="switchery" value="1"
					{!! $bookable->show_vat || old('show_vat')? 'checked' : null !!}
				/>
					<span class="text-muted">
						Mostrar este alquilable con IVA
					</span>
				</label>
			</div>
			@include('forms._validation-error', ['field' => 'show_vat'])
		</div>
	</div>

</div>
