<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Mosaiqo\Cqrs\DomainEventPublisher;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		view()->composer('*', function () {
			if ($user = Auth::user()) {
				view()->share('user', $user);
			}
		});

		Blade::directive('currencyFormat', function ($value) {
			return "<?php echo number_format($value, 2, ',', '.') . ' €'?>";
		});


	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$projections = [

		];

		    //new PersistEventSubscriber(new EloquentEventStore())
		$eventPublisher = DomainEventPublisher::instance();

		foreach ($projections as $projection) {
			$eventPublisher->subscribe($projection);
		}

	}
}
