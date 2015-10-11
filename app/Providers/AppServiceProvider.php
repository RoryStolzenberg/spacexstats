<?php

namespace SpaceXStats\Providers;

use Illuminate\Support\ServiceProvider;
use SpaceXStats\Extensions\ExtendedGuard;
use Illuminate\Auth\EloquentUserProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Auth::extend('roles', function() {
            return new ExtendedGuard(
                new EloquentUserProvider(\App::make('hash'), \Config::get('auth.model')),
                \App::make('session.store')
            );
        });
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
