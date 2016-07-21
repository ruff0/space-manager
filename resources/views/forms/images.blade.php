<label>Imágenes</label>
<div class="checkbox checkbox-switchery">
	<button type="button" class="btn btn-warning btn-sm legitRipple" data-toggle="modal"
	        data-target="#image-modal">
		Añade imágenes
		<i class="icon-stack-picture position-right"></i>
	</button>
	<div id="images-to-add" class="row mt-20">
		@if($entity->images)
			@foreach($entity->images as $image)
				<div class="col-lg-2 col-sm-6">
					<div class="thumbnail">
						<div class="thumb">
							<img src="/{{$image->pathname}}" alt="">
							<div class="caption-overflow">
						<span>
						<a href="#" data-id="{{$image->id}}"
						   class="btn btn-cross border-white text-white btn-flat btn-icon btn-rounded ml-5">
							<i class="icon-cross2"></i>
						</a>
						</span>
							</div>
						</div>
						<input type="hidden" name="images[]" value="{{$image->id}}"/>
					</div>
				</div>
			@endforeach
		@endif
	</div>
</div>


<div id="image-modal" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body" style="padding: 0">
				<div class="tabbable">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#image-gallery" data-toggle="tab">Galeria de imagenes</a></li>
						<li><a href="#image-upload" data-toggle="tab">Subir imagenes</a></li>
					</ul>

					<div class="tab-content" style="padding:1em">
						<div class="tab-pane active" id="image-gallery">
							@include('admin.files.index')
						</div>

						<div class="tab-pane" id="image-upload">
							@include('forms.file-upload')
						</div>

					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-warning" id="add-images">Añadir imagenes</button>
			</div>
		</div>
	</div>
</div>