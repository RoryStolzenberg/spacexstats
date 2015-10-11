<?php

namespace SpaceXStats\Providers;

use Illuminate\Support\ServiceProvider;
use SpaceXStats\Uploads\Checker;
use SpaceXStats\Uploads\Upload;

class UploadServiceProvider extends ServiceProvider
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
        $this->app->bind('upload', function() {
            return new Upload(new Checker());
        });
    }
}
