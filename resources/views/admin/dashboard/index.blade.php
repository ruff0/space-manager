@extends('admin.layouts.admin')

@section('body-class', '')

@section('content')
	<!-- Page content -->
<div class="page-content">

	@include('admin.common.sidebar')

	<!-- Main content -->
	<div class="content-wrapper">

		<!-- Content area -->
		<div class="content pb-20">
			Admin Dashboard
		</div>
		<!-- /content area -->

	</div>
	<!-- /main content -->

</div>
<!-- /page content -->

@endsection
