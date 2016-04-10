<!-- Vertical form modal -->
<div id="needsProfile" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Para continuar rellena tu perfil</h5>
			</div>

			<form action="{{ route('users.profiles.store', [$user->id]) }}" method="POST">
				<div class="modal-body">
					@include('users.profiles.forms.form')
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /vertical form modal -->