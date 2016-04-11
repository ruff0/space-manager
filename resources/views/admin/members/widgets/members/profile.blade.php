<div class="thumbnail">
	<div class="thumb thumb-rounded thumb-slide">
		<img src="{{$member->avatar(400)}}" alt="{{$member->email}}">
	</div>

	<div class="caption text-center">
		<h6 class="text-semibold no-margin">{{ $member->companyName() }}
			<small class="display-block">{{ $member->companyIdentity() }}</small>
		</h6>
	</div>
</div>
