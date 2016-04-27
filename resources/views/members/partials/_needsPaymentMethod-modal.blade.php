<!-- Vertical form modal -->
<div id="needsPaymentMethod" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Para continuar necesitamos que agregues un metodo de pago</h5>
			</div>
			<form action="{{ route('api.members.payment-methods.create', [$user->member->id]) }}" method="POST">
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<credit-card></credit-card>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /vertical form modal -->