<?php

namespace SpaceXStats\Creators\Objects;

use Illuminate\Support\ServiceProvider;

class ObjectCreatorServiceProvider extends ServiceProvider {

    public function register() {
        $this->app->bind('search', function() {
            return new ObjectCreator(new \Object());
        });
    }

}