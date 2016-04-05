<form action="{{ route('users.profiles.store', [$user->id]) }}" method="POST">
	@include('users.profiles.forms.form')
	<div class="modal-footer">
		{{--<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>--}}
		<button type="submit" class="btn btn-primary">Guardar</button>
	</div>
</form>