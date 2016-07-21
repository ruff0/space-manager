<div class="row">
	<div class="col-sm-6 col-xs-6 content-group">
		<img src="{{url('/images/ulab-logo_red-white.png')}}" class="content-group mt-10" alt="" style="width: 120px;">
		<ul class="list-condensed list-unstyled">
			<li>Proyectos Urbanos LI</li>
			<li>C.I.F. B54061130</li>
			<li>Avda. Ramón y Cajal, 12 - 1</li>
			<li>03003 Alicante</li>
			<li>Alicante</li>
		</ul>
	</div>

	<div class="col-sm-6 col-xs-6 content-group pull-right text-right">
		<div class="invoice-details">
			<h5 class="text-uppercase text-semibold">Factura #{{$invoice->number}}</h5>
			<ul class="list-condensed list-unstyled">
				<li>Fecha: <span class="text-semibold">{{$invoice->updated_at->format('d M Y')}}</span></li>
			</ul>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6 col-xs-6 col-lg-9 content-group">
		<span class="text-muted">Facturado a:</span>
		<ul class="list-condensed list-unstyled">
			<li>
				<h5>{{$invoice->company_name}}</h5>
			</li>
			<li>
				<span class="text-semibold">{{$invoice->company_identity}}</span>
			</li>
			<li>{{$invoice->address_line1}}</li>
			<li>{{$invoice->address_line2}}</li>
			<li>{{$invoice->zip}} {{$invoice->city}}</li>
			<li>{{$invoice->state}}</li>
			<li><a href="mailto:{{$invoice->email}}">{{$invoice->email}}</a></li>
		</ul>
	</div>

	<div class="col-md-6 col-xs-6 col-lg-3 pull-right text-right content-group">
		<span class="text-muted">Detalles del pago:</span>
		<ul class="list-condensed list-unstyled invoice-payment-details">
			<li>
				<h5>
					Total:
						<span class="text-right text-semibold">
							@currencyFormat($invoice->total / 100)
						</span>
				</h5>
			</li>
			<li>
				Forma de pago:
					<span class="text-semibold">
						Tarjeta de Credito
					</span>
			</li>
			<li>Tarjeta: <span>**** **** **** {{$invoice->member->card_last_four}}</span></li>
		</ul>
	</div>
</div>

<div class="table-responsive">
	<table class="table table-lg">
		<thead>
		<tr>
			<th class="col-sm-8">Descripción</th>
			<th class="col-sm-2">Precio</th>
			<th class="col-sm-1">Cantidad</th>
			<th class="col-sm-2">Total</th>
		</tr>
		</thead>
		<tbody>
		@foreach($invoice->lines as $line)
			<tr>
				<td class="col-sm-8">
					<h6 class="no-margin">{{$line->name}}</h6>
					<span class="text-muted">{{$line->description}}</span>
				</td>
				<td class="col-sm-2">@currencyFormat($line->price / 100)</td>
				<td class="col-sm-1">{{$line->amount}}</td>
				<td class="col-sm-2">
					<span class="text-semibold">
						@currencyFormat($line->subtotal / 100)
					</span>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>

<div class="panel-body no-padding-right no-margin-right">
	<div class="row invoice-payment no-padding no-margin">
		<div class="col-sm-8 col-xs-8">
			<div class="content-group">
				<h6>Persona autorizada</h6>
				<ul class="list-condensed list-unstyled text-muted">
					<li>{{$invoice->name}} {{$invoice->lastname}}</li>
					<li>{{$invoice->identity}}</li>
				</ul>
			</div>
		</div>

		<div class="col-sm-4 col-xs-4 no-padding no-margin">
			<div class="content-group">
				<h6></h6>
				<div class="table-responsive no-border">
					<table class="table">
						<tbody>
						<tr>
							<th>Subtotal:</th>
							<td class="text-right">
								@currencyFormat($invoice->subtotal / 100)
							</td>
						</tr>
						<tr>
							<th>I.V.A: <span class="text-regular">({{$invoice->vat}}%)</span></th>
							<td class="text-right">@currencyFormat($invoice->tax / 100)</td>
						</tr>
						<tr>
							<th>Total:</th>
							<td class="text-right text-primary">
								<h5 class="text-semibold">
									@currencyFormat($invoice->total / 100)
								</h5>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt-20 pt-20">
		<h6>Información adiccional</h6>
		<p class="text-muted">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit.
			Animi at, culpa doloremque dolores, eligendi et eveniet facilis,
			in iste laborum praesentium repudiandae sunt ut! Natus, necessitatibus,
			odit? Asperiores, autem tenetur.
		</p>
	</div>
</div>