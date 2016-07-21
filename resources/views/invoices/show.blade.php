@extends('layouts.app')

@section('body-class', '')

@section('page-scripts')
	<script src="/js/page/invoices.js"></script>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			@include('common.toolbar')
			<div class="content">
				<div class="row">
					<div class="col-lg-10">
						<div class="tabbable">
							<div class="tab-content">
								<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">Factura #{{$invoice->number}}</h6>
										<div class="heading-elements">
											<a href="{{route('invoices.download', [$invoice->id])}}" role="button"
											   class="btn btn-primary btn-labeled">
												<b>
													<i class="icon-file-download"></i>
												</b>
												Descargar
											</a>

											<a href="{{route('invoices.download', [$invoice->id])}}" role="button"
											   class="btn btn-primary btn-labeled">
												<b>
													<i class="icon-printer"></i>
												</b>
												Imprimir
											</a>

											<a href="" role="button" class="btn btn-primary btn-labeled">
												<b>
													<i class="icon-paperplane"></i>
												</b>
												Enviar
											</a>
										</div>
									</div>

									<div class="panel-body no-padding-bottom">
										<div class="row">
											<div class="col-sm-8 col-sm-offset-2">
												@include('invoices.invoice')
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						@include('common.sidebar')
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection