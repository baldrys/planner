<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EloquentObserverServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \App\DayActivity::observe(\App\Observers\DayActivityObserver::class);
        \App\Activity::observe(\App\Observers\ActivityObserver::class);
    }
}
