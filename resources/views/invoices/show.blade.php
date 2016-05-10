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
								@include('invoices.invoice')
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