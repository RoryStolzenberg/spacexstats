<?php
namespace SpaceXStats\Library\Launch;

use SpaceXStats\Models\Mission;
use SpaceXStats\Models\PrelaunchEvent;

class LaunchProbabilityCalculator {
	private $mission;

	public function __construct($mission_id) {
		$this->mission = Mission::find($mission_id);
	}

	public function get() {
		$launchChanges = PrelaunchEvent::where('event','Launch Change')->whereHas('mission', function($q) {
			$q->where('status','Complete');
		})->orderBy('mission_id')->orderBy('prelaunch_event_id')->get();
		$countOfCompletedMissions = Mission::where('status','Complete')->get();

		print_r($launchChanges);
	}
}