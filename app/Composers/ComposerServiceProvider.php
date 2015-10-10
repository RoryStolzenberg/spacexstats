<?php
namespace SpaceXStats\Composers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {
	public function register() {
		$this->app->view->composer('templates.header', 'SpaceXStats\Composers\HeaderComposer');
	}
}