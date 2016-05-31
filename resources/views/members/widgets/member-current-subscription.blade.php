{{-- Current Plan --}}
@inject('currentMember', 'App\Space\Services\CurrentMember')
<?php $member = $currentMember->loadMember() ?>

<div class="panel panel-flat border-left-lg border-left-danger invoice-grid timeline-content">
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-6">
				<h6 class="text-semibold no-margin-top">{{$member->companyName()}}</h6>
				<ul class="list list-unstyled">
					<li>
						Plan actual: <br>
						<span class="text-semibold">
							@if($member->currentPlan())
								{{$member->currentPlan()->name}}
							@else
								@inject('plan', 'App\Space\Plan')
								{{ $plan->byDefault()->name }}
							@endif
						</span>
					</li>
				</ul>
			</div>

			<div class="col-sm-6">
				<h6 class="text-semibold text-right no-margin-top">{{$member->companyIdentity()}}</h6>
				<ul class="list list-unstyled text-right">
					<li class="dropdown">
						<div class="label
														{!! $member->active ? 'label-success' : 'label-danger' !!}">
							{!! $member->active ? 'Activo' : 'Inactivo' !!}
						</div>
					</li>
				</ul>
			</div>

			<div class="col-sm-12 mt-20">
				<div class="thumbnail no-padding plans">
					<div class="thumb">
						@if($member->currentPlan())
							<img src="{{$member->currentPlan()->mainImage()}}" alt="">
						@else
							@inject('plan', 'App\Space\Plan')
							<img src="{{$plan->byDefault()->mainImage()}}" alt="">
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel-footer panel-footer-condensed">
		<div class="heading-elements">
			<span class="heading-text">
				<span class="status-mark border-danger position-left"></span>
				Miembro desde:
				<span class="text-semibold">
					{{$member->created_at->format('d/m/Y')}}
				</span>
			</span>

			<ul class="list-inline list-inline-condensed heading-text pull-right">
				<li class="dropdown">
					<a href="#" class="text-default dropdown-toggle" data-toggle="dropdown">
						<i class="icon-menu7"></i>
						<span class="caret"></span>
					</a>
					@if($invoice =  $member->getCurrentSubscriptionInvoice())
						<ul class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
						<li>
							<a href="{{route('invoices.show', ['id' => $invoice->id ])}}">
								<i class="icon-file-eye"></i>
								Ver última factura
							</a>
						</li>
						<li>
							<a href="{{route('invoices.download', ['id' => $invoice->id ])}}">
								<i class="icon-file-download"></i>Descargar última factura
							</a>
						</li>
						@if($member->currentPlan() && !$member->isOnGracePeriod())
							<li class="divider"></li>
							<li>
								<a href="#" role="button" data-toggle="modal" data-target="#cancelSubscription">
									<i class="icon-cross2"></i>
									Cancelar suscripción
								</a>
							</li>
						@endif
					</ul>
					@endif
				</li>
			</ul>
		</div>
	</div>
</div>
{{-- /Current Plan --}}