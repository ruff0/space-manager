<div class="panel panel-flat">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-users position-left"></i> Usuarios</h6>
		<div class="heading-elements">
			<ul class="icons-list">
				<li><a data-action="collapse"></a></li>
				<li><a data-action="reload"></a></li>
				<li><a data-action="close"></a></li>
			</ul>
		</div>
		<a class="heading-elements-toggle"><i class="icon-more"></i></a></div>

	<div class="panel-body">
		<ul class="media-list">
			@foreach($users as $user)
			<li class="media">
				<div class="media-left">
					<img src="{{$user->avatar()}}" class="img-sm img-circle" alt="">
				</div>

				<div class="media-body media-middle text-semibold">
					{{ $user->fullName() }}
					<div class="media-annotation">{{$user->email}}</div>
				</div>

			</li>
		 @endforeach
		</ul>
	</div>
</div>