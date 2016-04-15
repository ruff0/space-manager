
<div class="panel panel-white">
	<div class="panel-heading">
		<h6 class="panel-title">
			<a data-toggle="collapse" href="#collapse-group1">Precios</a>
		</h6>
	</div>
	<div id="collapse-group1" class="panel-collapse collapse in">
		<div class="panel-body">
			<ul class="media-list media-list-container resources-list-container" data-list="available-resources">
				@inject('resources', 'App\Resources\Models\Resource')
				@foreach($resources->ofType("price")->notSelectedBy($bookable)->get() as $resource)
					@include('admin.resources.resource-list-item')
				@endforeach
			</ul>
		</div>
	</div>
</div>

<div class="panel panel-white">
	<div class="panel-heading">
		<h6 class="panel-title">
			<a data-toggle="collapse" href="#collapse-group1">Salas disponibles</a>
		</h6>
	</div>
	<div id="collapse-group1" class="panel-collapse collapse in">
		<div class="panel-body">
			<ul class="media-list media-list-container resources-list-container" data-list="available-resources">
				@inject('resources', 'App\Resources\Models\Resource')
				@foreach($resources->ofType("meetingroom")->notSelectedBy($bookable)->get() as $resource)
					@include('admin.resources.resource-list-item')
				@endforeach
			</ul>
		</div>
	</div>
</div>

<div class="panel panel-white">
	<div class="panel-heading">
		<h6 class="panel-title">
			<a class="collapsed" data-toggle="collapse" href="#collapse-group2">Puestos disponibles</a>
		</h6>
	</div>
	<div id="collapse-group2" class="panel-collapse collapse in">
		<div class="panel-body">
			<ul class="media-list media-list-container resources-list-container" data-list="available-resources">
				@inject('resources', 'App\Resources\Models\Resource')
				@foreach($resources->ofType("spot")->notSelectedBy($bookable)->get() as $resource)
					@include('admin.resources.resource-list-item', ['actions' => true])
				@endforeach
			</ul>
		</div>
	</div>
</div>

<div class="panel panel-white">
	<div class="panel-heading">
		<h6 class="panel-title">
			<a class="collapsed" data-toggle="collapse" href="#collapse-group3">Aulas disponibles</a>
		</h6>
	</div>
	<div id="collapse-group3" class="panel-collapse collapse in">
		<div class="panel-body">
			<ul class="media-list media-list-container resources-list-container" data-list="available-resources">
				@inject('resources', 'App\Resources\Models\Resource')
				@foreach($resources->ofType("classroom")->notSelectedBy($bookable)->get() as $resource)
					@include('admin.resources.resource-list-item')
				@endforeach
			</ul>
		</div>
	</div>
</div>
</div>