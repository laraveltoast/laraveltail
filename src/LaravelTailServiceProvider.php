<?php

namespace laraveltoast\laraveltail;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class LaravelTailServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     * @author Suraj Mishra <suraj.mishra@sterlite.com>
     * @return void
     */
    public function boot() {
        //
        $this->loadViewsFrom(__DIR__ . '/views', 'laraveltail');
    }

    /**
     * Register the application services.
     * @author Suraj Mishra <suraj.mishra@sterlite.com>
     * @return void
     */
    public function register() {
        //

        include __DIR__ . '/routes.php';
        if ($this->app->runningInConsole()) {
            $this->commands([
                LaravelTailCommand::class,
            ]);
        }
        Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
            // filter oauth ones
            if (!str_contains($query->sql, 'oauth')) {
                Log::debug($query->sql . ' Bindings to' . serialize($query->bindings));
            }
            //  View::share('dblog', $queries);
        });
    }

    /**
     * Get the services provided by the provider.
     * @author Suraj Mishra <suraj.mishra@sterlite.com>
     * @return array
     */
    public function provides() {
        return ['command.tail'];
    }

}
