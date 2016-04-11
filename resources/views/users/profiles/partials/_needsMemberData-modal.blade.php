<!-- Vertical form modal -->
<div id="needsMemberData" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Para continuar rellena tu perfil</h5>
			</div>

			<form action="{{ route('members.update', [$member->id]) }}" method="POST">
				<div class="modal-body">
					{{ method_field('PUT') }}
					@include('members.forms.form')
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /vertical form modal -->