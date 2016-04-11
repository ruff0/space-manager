@extends('admin.layouts.admin')

@section('body-class', '')

@section('new-form-text', 'Crear nuevo miembro')
@section('new-form-url', route('admin.members.create'))

@section('content')
	<!-- Page content -->
<div class="page-content">

	@include('admin.common.sidebar')
	<div class="content-wrapper">
		@include('admin.common.header')
		<div class="content pb-20">
			<div class="col-sm-9">
				@include("admin.members.widgets.members.details", ['member' => $member])
			</div>
			<div class="col-sm-3">
				@include("admin.members.widgets.members.profile", ['member' => $member])
				@include("admin.members.widgets.users.index", ['users' => $member->users])
			</div>
		</div>
	</div>
</div>
@endsection
