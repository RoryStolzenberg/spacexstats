<?php
namespace SpaceXStats\Search;

use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider {

    public function register() {
        $this->app->bind('search', 'SpaceXStats\Search\Search');
    }

}