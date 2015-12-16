<?php
namespace SpaceXStats\Composers;

use SpaceXStats\Models\Mission;

class HeaderComposer {
	public function compose($view) {

		$nearby = Cache::remember('nearbyMissions', 60, function() {
			$nearby['past'] = Mission::past()->take(3)->get();
			$nearby['future'] = Mission::future()->take(3)->get();

			return $nearby;
		});

		$view->with('nearbyMissions', [
			'past' => $nearby['past'],
			'future' => $nearby['future']
		]);
	}
}