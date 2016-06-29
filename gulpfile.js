var elixir = require('laravel-elixir');
						 require('laravel-elixir-vueify');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
	mix
		.less('app.less')
		.less('pdf.less')
		.copy('./resources/assets/css', './public/css')
		.copy('./resources/assets/images', './public/images')
		.copy('./resources/assets/icons', './public/fonts')
		.copy('./resources/assets/js/page', './public/js/page')
		.scripts([
			'plugins/loaders/pace.min.js',
			'core/libraries/jquery.min.js',
			'core/libraries/bootstrap.min.js',
			'core/libraries/jasny_bootstrap.min.js',
			'plugins/pickers/anytime.min.js',
			'plugins/pickers/pickadate/picker.js',
			'plugins/pickers/pickadate/picker.date.js',
			'plugins/pickers/pickadate/picker.time.js',
			'plugins/pickers/pickadate/legacy.js',
			'plugins/forms/wizards/steps.min.js',
			'plugins/forms/validation/validate.min.js',
			'plugins/extensions/cookie.js',
			'plugins/loaders/blockui.min.js',
			'core/libraries/jquery_ui/widgets.min.js',
			'core/libraries/jquery_ui/interactions.min.js',
			'plugins/tables/datatables/datatables.min.js',
			'plugins/tables/datatables/extensions/natural_sort.js',
			'plugins/forms/selects/select2.min.js',
			'plugins/forms/styling/uniform.min.js',
			'plugins/forms/styling/switchery.min.js',
			'plugins/forms/selects/select2.min.js',
			'plugins/ui/dragula.min.js',
			'plugins/notifications/sweet_alert.min.js',
			'plugins/notifications/pnotify.min.js',
			'plugins/uploaders/dropzone.min.js',
			'plugins/ui/jquery.dragster.js',
			'plugins/velocity/velocity.min.js',
			'plugins/velocity/velocity.ui.min.js',
			'plugins/buttons/spin.min.js',
			'plugins/buttons/ladda.min.js',
			'core/app.js',
			'pages/form_checkboxes_radios.js',
			'pages/login.js',
			'plugins/ui/ripple.min.js',

			"./bower_components/moment/moment.js",
			"./bower_components/fullcalendar/dist/fullcalendar.min.js",
			"./bower_components/fullcalendar-scheduler/dist/scheduler.min.js",
		])
		.scripts(
			[
				'page/admin/bookings.js',
				'page/admin/bookables.js',
				'page/admin/meetingrooms.js',
				'page/admin/offices.js',
				'page/admin/classrooms.js',
				'page/admin/spots.js',
				'page/admin/bookabletypes.js',
				'page/admin/plantypes.js',
				'page/admin/members.js',
				'page/admin/plans.js',
				'main.js'
			],
			'./public/js/pages.js'
		)
		.copy('js/page/', 'public/js/page')
		.browserify('app.js')
		.browserify('admin.js');
});
