<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\DayActivityService;
use App\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        config(['app.locale' => 'ru']);
        \Carbon\Carbon::setLocale('ru');

        // $this->app->bind(DayActivityService::class,function($app){
        //     return new DayActivityService()
        // })
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
