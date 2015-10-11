<?php

namespace SpaceXStats\Providers;

use Illuminate\Support\ServiceProvider;
use SpaceXStats\Search\Search;

class SearchServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('search', function() {
            return new Search();
        });
    }
}
