<!-- Vertical form modal -->
<div id="needsMemberData" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Completa tu perfil</h5>
			</div>

			<form action="{{ route('members.update', [$member->id]) }}" method="POST">
				<input type="hidden" name="redirect" value="home">
				<div class="modal-body">
					{{ method_field('PUT') }}
					@include('members.forms.form')
				</div>
				<div class="modal-footer">
					<span class="pull-left">Los campos con  <sup>*</sup> son obligatorios</span>
					<button type="submit" class="btn btn-primary" name="save">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /vertical form modal -->