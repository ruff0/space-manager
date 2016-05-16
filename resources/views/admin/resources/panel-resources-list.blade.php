
<div class="panel panel-white panel-collapsed">
	@inject('resources', 'App\Resources\Models\Resource')
	<div class="panel-heading">
		<h6 class="panel-title">
			Salas disponibles
			<small>({{$resources->ofType("meetingroom")->notSelectedBy($entity)->count()}})</small>
		</h6>
		<div class="heading-elements">
			<ul class="icons-list">
				<li><a data-action="collapse"></a></li>
			</ul>
		</div>
	</div>
	<div id="collapse-group1" class="panel-collapse collapse in">
		<div class="panel-body">
			<ul class="media-list media-list-container resources-list-container" data-list="available-resources">
				@foreach($resources->ofType("meetingroom")->notSelectedBy($entity)->get() as $resource)
					@include('admin.resources.resource-list-item')
				@endforeach
			</ul>
		</div>
	</div>
</div>

<div class="panel panel-white panel-collapsed">
	@inject('resources', 'App\Resources\Models\Resource')
	<div class="panel-heading">
		<h6 class="panel-title">
			Puestos disponibles
			<small>({{$resources->ofType("spot")->notSelectedBy($entity)->count()}})</small>
		</h6>
		<div class="heading-elements">
			<ul class="icons-list">
				<li><a data-action="collapse"></a></li>
			</ul>
		</div>
	</div>
	<div id="collapse-group2" class="panel-collapse collapse in">
		<div class="panel-body">
			<ul class="media-list media-list-container resources-list-container" data-list="available-resources">
				@foreach($resources->ofType("spot")->notSelectedBy($entity)->get() as $resource)
					@include('admin.resources.resource-list-item', ['actions' => true , 'type' => isset($type)?$type:null])
				@endforeach
			</ul>
		</div>
	</div>
</div>

<div class="panel panel-white panel-collapsed">
	@inject('resources', 'App\Resources\Models\Resource')
	<div class="panel-heading">
		<h6 class="panel-title">
			Despachos disponibles
			<small>({{$resources->ofType("office")->notSelectedBy($entity)->count()}})</small>
		</h6>
		<div class="heading-elements">
			<ul class="icons-list">
				<li><a data-action="collapse"></a></li>
			</ul>
		</div>
	</div>
	<div id="collapse-group3" class="panel-collapse collapse in">
		<div class="panel-body">
			<ul class="media-list media-list-container resources-list-container" data-list="available-resources">
				@foreach($resources->ofType("office")->notSelectedBy($entity)->get() as $resource)
					@include('admin.resources.resource-list-item')
				@endforeach
			</ul>
		</div>
	</div>
</div>

<div class="panel panel-white panel-collapsed">
	@inject('resources', 'App\Resources\Models\Resource')
	<div class="panel-heading">
		<h6 class="panel-title">
			Aulas disponibles
			<small>({{$resources->ofType("classroom")->notSelectedBy($entity)->count()}})</small>
		</h6>
		<div class="heading-elements">
			<ul class="icons-list">
				<li><a data-action="collapse"></a></li>
			</ul>
		</div>
	</div>
	<div id="collapse-group3" class="panel-collapse collapse in">
		<div class="panel-body">
			<ul class="media-list media-list-container resources-list-container" data-list="available-resources">
				@foreach($resources->ofType("classroom")->notSelectedBy($entity)->get() as $resource)
					@include('admin.resources.resource-list-item')
				@endforeach
			</ul>
		</div>
	</div>
</div>
