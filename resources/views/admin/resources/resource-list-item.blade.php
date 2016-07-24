<?php $selectedResource = isset($selectedResource)?$selectedResource:false; ?>

<li class="media border-left-primary" data-resourceable-type="{{ $resource->resourceable->type }}">
	<div class="media-left media-middle">
		<i class="icon-move dragula-handle"></i>
	</div>

	<div class="media-left">
		<a href="#"><img src="/images/placeholder.jpg" class="img-circle" alt=""></a>
	</div>

	<div class="media-body">
		<div class="media-left">
			<div class="media-heading text-semibold">
				{{$resource->resourceable->name}}
				@if($resource->resourceable->max_occupants)
					<span class="label bg-blue">{{$resource->resourceable->max_occupants}} max.</span>
				@endif
			</div>
			{{$resource->resourceable->description}}
		</div>
		<div class="media-right media-middle">
			<input type="hidden" name="resources[]" value="{{  $resource->id }}" />

			@if(isset($type) && $type == 'booking')
				<div class="form form-inline @if(!$selectedResource) hidden @endif">
				<div class="form-group">
					<label for="">Precio (en Euros)</label>
					<input type="text" class="form-control"
					       name="resources[{{$resource->id}}][settings][price][hourly]"
					       value="{{  $resource->settings('price')
					       ?  number_format($resource->settings('price')->hourly / 100 , 2)
					       : ""
					       }}"
					       placeholder="por hora"
					/>
				</div>
				<div class="form-group form-inline">
					<input type="text" class="form-control"
					       name="resources[{{$resource->id}}][settings][price][part_time]"
					       value="{{  $resource->settings('price')
					        ? number_format($resource->settings('price')->part_time / 100 , 2)
					        : ""
					        }}"
					       placeholder="media jornada"
					/>
				</div>
				<div class="form-group form-inline">
					<input type="text" class="form-control"
					       name="resources[{{$resource->id}}][settings][price][full_time]"
					       value="{{  $resource->settings('price')
					       ?  number_format($resource->settings('price')->full_time / 100  , 2 )
					       : ""
					       }}"
					       placeholder="jornada completa"
					/>
				</div>
			</div>
			@endif

			@if(isset($type) && $type == 'booking' && $resource->resourceable_type == "App\Resources\Models\ClassRoom")
				<div class="form form-inline @if(!$selectedResource) hidden @endif">
				<div class="form-group">
					<label for="">Distribuciones disponibles</label>
					<label for="resources[{{$resource->id}}][settings][distributions][u]">
					<input type="checkbox" class="form-control"
					       name="resources[{{$resource->id}}][settings][distributions][u]"
					       value="1"
					       id="resources[{{$resource->id}}][settings][distributions][u]"
					       @if($resource->settings('distributions') && isset($resource->settings('distributions')->u)) checked @endif
					/>
						Distribucion en U (18 pax.)
					</label>

					<label for="resources[{{$resource->id}}][settings][distributions][line]">
					<input type="checkbox" class="form-control"
					       name="resources[{{$resource->id}}][settings][distributions][line]"
					       value="1"
					       id="resources[{{$resource->id}}][settings][distributions][line]"
					       @if($resource->settings('distributions') && isset($resource->settings('distributions')->line)) checked @endif
					/>
						Distribucion en U  (18 pax.)
					</label>

					<label for="resources[{{$resource->id}}][settings][distributions][chairs]">
					<input type="checkbox" class="form-control"
					       name="resources[{{$resource->id}}][settings][distributions][chairs]"
					       value="1"
					       id="resources[{{$resource->id}}][settings][distributions][chairs]"
					       @if($resource->settings('distributions') && isset($resource->settings('distributions')->chairs)) checked @endif
					/>
						Solo sillas (30 pax.)
					</label>
				</div>
			</div>
			@endif
		</div>
	</div>
	{{--@if(isset($actions) && $actions)--}}
		{{--<div class="media-right media-middle">--}}
			{{--<ul class="icons-list text-nowrap">--}}
				{{--<li>--}}
					{{--<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>--}}
					{{--<ul class="dropdown-menu dropdown-menu-right">--}}
						{{--<li><a href="#"><i class="icon-comment-discussion pull-right"></i> Start chat</a></li>--}}
						{{--<li><a href="#"><i class="icon-phone2 pull-right"></i> Make a call</a></li>--}}
						{{--<li><a href="#"><i class="icon-mail5 pull-right"></i> Send mail</a></li>--}}
						{{--<li class="divider"></li>--}}
						{{--<li><a href="#"><i class="icon-statistics pull-right"></i> Statistics</a></li>--}}
					{{--</ul>--}}
				{{--</li>--}}
			{{--</ul>--}}
		{{--</div>--}}
	{{--@endif--}}
</li>