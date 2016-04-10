<!-- Page header -->
<div class="page-header">
	<div class="page-header-content">
		<div class="page-title">
			<h4>
				<i class="icon-cash3 position-left"></i>
				<span class="text-semibold">{{ $current['model'] }}</span> - {{ $current['action'] }}
			</h4>
		</div>

		{{--<div class="heading-elements">--}}
			{{--<div class="heading-btn-group">--}}
				{{--<a href="#" class="btn btn-link btn-float text-size-small has-text"><i--}}
						{{--class="icon-bars-alt text-primary"></i><span>Statistics</span></a>--}}
				{{--<a href="#" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calculator text-primary"></i>--}}
					{{--<span>Invoices</span></a>--}}
				{{--<a href="#" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calendar5 text-primary"></i>--}}
					{{--<span>Schedule</span></a>--}}
			{{--</div>--}}
		{{--</div>--}}
		<div class="heading-elements">
			<a href="@yield('new-form-url', '#')" class="btn bg-blue btn-labeled heading-btn legitRipple">
				<b>
					<i class="icon-cash"></i>
				</b>
				@yield('new-form-text', 'Crear nuevo')
			</a>
		</div>
	</div>
</div>
<!-- /page header -->