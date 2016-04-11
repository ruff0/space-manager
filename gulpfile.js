var elixir = require('laravel-elixir');

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
		.copy('./resources/assets/css', './public/css')
		.copy('./resources/assets/images', './public/images')
		.copy('./resources/assets/icons', './public/fonts')
		.copy('./resources/assets/js/page', './public/js/page')
		.scripts([
			'plugins/loaders/pace.min.js',
			'core/libraries/jquery.min.js',
			'core/libraries/bootstrap.min.js',
			'plugins/loaders/blockui.min.js',
			'core/libraries/jquery_ui/widgets.min.js',
			'plugins/tables/datatables/datatables.min.js',
			'plugins/tables/datatables/extensions/natural_sort.js',
			'plugins/forms/selects/select2.min.js',
			'plugins/forms/styling/uniform.min.js',
			'plugins/forms/styling/switchery.min.js',
			'plugins/notifications/pnotify.min.js',
			'core/app.js',
			'pages/form_checkboxes_radios.js',
			'pages/login.js',
			'plugins/ui/ripple.min.js'
		])
		.scripts(
			[
				'page/admin/members.js',
				'page/admin/plans.js',
				'admin.js'
			],
			'./public/js/admin.js'
		)
		.scripts(
			[
				'page/home.js',
				'app.js'
			],
			'./public/js/all.js'
		);
});
