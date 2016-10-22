<?php

namespace App\Providers;

use App\Events\Infrastructure\Repositories\EloquentEventRepositories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Mosaiqo\Cqrs\DomainEventPublisher;
use Mosaiqo\Cqrs\EloquentEventStore;
use Mosaiqo\Cqrs\PersistEventSubscriber;

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

		DomainEventPublisher::instance()->subscribe(
			new PersistEventSubscriber( new EloquentEventStore() )
		);
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
