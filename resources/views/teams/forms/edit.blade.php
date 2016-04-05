<form action="{{ route('teams.update', [$team->id]) }}" method="POST">
	{{ method_field('PUT') }}
	@include('teams.forms.form')
	<button type="submit" class="btn btn-primary pull-right">Guardar</button>
</form>