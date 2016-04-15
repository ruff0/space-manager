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
			<div class="form" style="display:none;">
				<input type="hidden" name="resources[{{$resource->id}}][settings][time]" value="3600">
				<input type="text" name="resources[{{$resource->id}}][settings][price]" value="">
			</div>
		</div>
	</div>
	@if(isset($actions) && $actions)
		<div class="media-right media-middle">
			<ul class="icons-list text-nowrap">
				<li>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="#"><i class="icon-comment-discussion pull-right"></i> Start chat</a></li>
						<li><a href="#"><i class="icon-phone2 pull-right"></i> Make a call</a></li>
						<li><a href="#"><i class="icon-mail5 pull-right"></i> Send mail</a></li>
						<li class="divider"></li>
						<li><a href="#"><i class="icon-statistics pull-right"></i> Statistics</a></li>
					</ul>
				</li>
			</ul>
		</div>
	@endif
</li>