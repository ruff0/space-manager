<!-- Vertical form modal -->
<div id="cancelSubscription" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Cancelar suscripción actual</h5>
			</div>
			<form class=""
			      action="{{ route('subscriptions.cancel', [$user->member->subscription()->id ]) }}"
			      method="POST">
				{{ csrf_field() }}
				@if(session('cancelSubscriptionNextMonth'))
					<input type="hidden" name="next-month" value="true">
				@endif
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-10 col-sm-offset-1">
							<div class="alert alert-danger">
								Al cancelar tu plan actual, ya no se te cobrara en el siguiente ciclo de facturación. <br>
								No obstante pódras seguir disfrutando de tu plan hasta entonces.
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-10 col-sm-offset-1">
							<div class="form-group">
								<label>Password
									@include('forms._validation-error', ['field' => 'password'])
								</label>
								<input type="password"
								       placeholder="*****"
								       class="form-control"
								       name="password"
								       value=""
								/>
							</div>
						</div>
						<div class="col-sm-10 col-sm-offset-1">
							<div class="form-group">
								<span
									class="text-muted col-md-12">Para poder cancelar tu plan necesitamos que ingreses tu contraseña</span>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-default">Mantener mi plan actual</button>
					@if(session('cancelSubscriptionNextMonth'))
						<button type="submit" class="btn btn-danger">Cancelar mi plan despúes de la siguiente factura</button>
					@else
						<button type="submit" class="btn btn-danger">Si cancelar mi plan</button>
					@endif
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /vertical form modal -->