<?php
namespace SpaceXStats\Uploads;

use Illuminate\Support\ServiceProvider;

class UploadServiceProvider extends ServiceProvider {

    public function register() {
        $this->app->bind('upload', function() {
            return new Upload();
        });
    }

}