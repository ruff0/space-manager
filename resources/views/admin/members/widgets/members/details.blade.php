<div class="panel panel-flat">
	<div class="panel-heading">
		<h6 class="panel-title">
			<i class="icon-files-empty position-left"></i>
			Detalles de <span class="text-bold">{{$member->companyName()}}</span>
		</h6>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-6">
				<table class="table table-borderless table-xs content-group-xs">
					<tbody>
					<tr>
						<td>
							<i class="icon-user position-left"></i>
							Nombre:
						</td>
						<td class="text-left">
							<span class="pull-right">
								{{$member->name}}
							</span>
						</td>
					</tr>

					<tr>
						<td>
							<i class="icon-user position-left"></i>
							Apellidos:
						</td>
						<td class="text-right">
							{{$member->lastname}}
						</td>
					</tr>

					<tr>
						<td>
							<i class="icon-newspaper position-left"></i>
							NIF / NIE:
						</td>
						<td class="text-right">
							{{$member->identity}}
						</td>
					</tr>

					<tr>
						<td>
							<i class="icon-home2 position-left"></i>
							Dirección:
						</td>
						<td class="text-right">
							{{$member->address_line1}}
						</td>
					</tr>

					<tr>
						<td></td>
						<td class="text-right">
							{{$member->address_line2}}
						</td>
					</tr>

					<tr>
						<td>
							<i class="icon-alarm-add position-left"></i>
							Provincia:
						</td>
						<td class="text-right">
							{{$member->state}}
						</td>
					</tr>

					<tr>
						<td>
							<i class="icon-city position-left"></i>
							Ciudad:
						</td>
						<td class="text-right">
							{{$member->city}}
						</td>
					</tr>

					<tr>
						<td>
							<i class="icon-mailbox position-left"></i>
							Código Postal:
						</td>
						<td class="text-right">
							{{$member->zip}}
						</td>
					</tr>
					</tbody>
				</table>
			</div>

			<div class="col-lg-6">
				<table class="table table-borderless table-xs content-group-xs">
					<tbody>
					@if($member->isCompany())
					<tr>
						<td>
							<i class="icon-office position-left"></i>
							Razón Social:
						</td>
						<td class="text-left">
							<span class="pull-right">
								{{$member->company_name}}
							</span>
						</td>
					</tr>
					<tr>
						<td>
							<i class="icon-briefcase position-left"></i>
							CIF:
						</td>
						<td class="text-right">
							{{$member->company_identity}}
						</td>
					</tr>
					@endif

					<tr>
						<td>
							<i class="icon-envelop position-left"></i>
							Email:
						</td>
						<td class="text-right">
							{{$member->email}}
						</td>
					</tr>

					<tr>
						<td>
							<i class="icon-phone position-left"></i>
							Télefono:
						</td>
						<td class="text-right">
							{{$member->phone}}
						</td>
					</tr>
					<tr>
						<td>
							<i class="icon-mobile position-left"></i>
							Móvil:
						</td>
						<td class="text-right">
							{{$member->mobile}}
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="panel-footer panel-footer-condensed">
		<div class="heading-elements">
			<ul class="list-inline list-inline-condensed heading-text">
				<li><a href="{{route('admin.members.edit', [$member->id])}}" class="text-default"><i class="icon-pencil7"></i></a></li>
			</ul>

			<ul class="list-inline list-inline-condensed heading-text pull-right">
				<li class="dropdown">
					<a href="#" class="text-default dropdown-toggle" data-toggle="dropdown"><i class="icon-gear"></i><span
							class="caret"></span></a>
					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="{{route('admin.members.destroy', [$member->id])}}"
						       role="delete-form"
						       data-id="{{$member->id}}"
						       data-token="{{ csrf_token() }}"
						       class="text-default"
							>
								<i class="icon-bin"></i> Borrar
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		<a class="heading-elements-toggle"><i class="icon-more"></i></a></div>
</div>