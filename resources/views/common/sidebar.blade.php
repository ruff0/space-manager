{{--UserProfile--}}
<div class="thumbnail">
	<div class="thumb thumb-rounded thumb-slide">
		<img src="{{ $user->avatar(200) }}" alt="" height="200">
		<div class="caption">
			<span>
				<a href="#" class="btn bg-success-400 btn-icon btn-xs legitRipple" data-popup="lightbox">
					<i class="icon-plus2"></i>
				</a>
				<a href="#" class="btn bg-success-400 btn-icon btn-xs legitRipple">
					<i class="icon-link"></i>
				</a>
			</span>
		</div>
	</div>

	<div class="caption text-center">
		<h6 class="text-semibold no-margin">{{$user->name}}
			<small class="display-block">{{$user->email}}</small>
		</h6>
	</div>
</div>
{{--/UserProfile--}}

@include('members.widgets.member-current-subscription')


{{-- Navigation --}}
<div class="panel panel-flat">
	<div class="list-group no-border">
		@if($user->hasProfile())
			<a href="{{route('users.profiles.edit', [$user->id, $user->profile->id])}}" class="list-group-item">
				<i class="icon-user"></i> Mi perfil
			</a>
		@endif
		<div class="list-group-divider"></div>
		<a href="{{route('members.edit', [$user->member->id])}}" class="list-group-item">
			<i class="icon-cog3"></i> Mi cuenta
		</a>
	</div>
</div>
{{-- /navigation --}}