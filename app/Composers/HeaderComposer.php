<?php
namespace SpaceXStats\Composers;

use SpaceXStats\Models\Mission;

class HeaderComposer {
	public function compose($view) {

        /* \Event::listen('illuminate.query', function($q) {
			print_r($q);
		});*/

		$view->with('nearbyMissions', array(
			'past' => Mission::past(3)->get(),
			'future' => Mission::future(3)->get()
		));
	}
}