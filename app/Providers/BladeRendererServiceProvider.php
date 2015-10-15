<?php

namespace SpaceXStats\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Windwalker\Renderer\BladeRenderer;

class BladeRendererServiceProvider extends ServiceProvider
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
        App::bind('bladeRenderer', function() {
            return new BladeRenderer(array(base_path() . '/resources/assets/templates'), array('cache_path' => base_path() . '/storage/framework/views', 'local_variables' => true));
        });
    }
}
