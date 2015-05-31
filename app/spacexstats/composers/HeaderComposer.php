<?php
namespace SpaceXStats\Composers;

class HeaderComposer {
	public function compose($view) {

/*		\Event::listen('illuminate.query', function($q) {
			print_r($q);
		});*/

		$view->with('nearbyMissions', array(
			'past' => \Mission::previousMissions(3)->get(),
			'future' => \Mission::nextMissions(3)->get()
		));
	}
}