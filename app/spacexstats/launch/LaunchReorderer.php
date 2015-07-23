<?php
namespace SpaceXStats\Launch;

use SpaceXStats\Enums\LaunchSpecificity;

class LaunchReorderer {
	protected $mission, $scheduledLaunch, $currentLaunchOrderId;

	public function __construct(\Mission $currentMissionReference, $scheduledLaunch) {
        $this->mission = $currentMissionReference;
        $this->scheduledLaunch = $scheduledLaunch;
        $this->currentMissionDt = LaunchDateTimeResolver::parseString($scheduledLaunch);
	}

    // Returns a launch date time instance
	public function run() {
        // Grab all missions as an array, pass them through
        if (is_null($this->mission->mission_id)) {
            $allMissions = \Mission::orderBy('launch_order_id', 'ASC')->get();
        } else {
            $allMissions = \Mission::where('mission_id', '!=', $this->mission->mission_id)->orderBy('launch_order_id', 'ASC')->get();
        }

        $arrayedMissions = $allMissions->toArray();

        // Add the mission we are running from to the array
        array_push($arrayedMissions, array('context' => true, 'launchDateTime' => $this->scheduledLaunch));

        // Sort the missions by launchDateTime
        // Use the at symbol because http://stackoverflow.com/a/10985500/1064923
        @usort($arrayedMissions, function($a, $b) {
            $ldta = LaunchDateTimeResolver::parseString($a['launchDateTime']);
            $ldtb = LaunchDateTimeResolver::parseString($b['launchDateTime']);

            return LaunchDateTime::compare($ldta, $ldtb);
        });

        // Update each mission's launch_order_id
        foreach ($arrayedMissions as $index => $arrayedMission) {
            // If the context is from the current mission, set the current mission properties
            if (array_get($arrayedMission, 'context', false) == true) {
                $this->setMissionProperties($index);

            // Else, update the mission properties if it needs updating
            } else {
                // Check to see if it actually needs updating in the db
                if ($arrayedMission['launch_order_id'] !== $index + 1) {
                    $missionModel = $allMissions->keyBy('launch_order_id')->find($arrayedMission['launch_order_id']);
                    $missionModel->launch_order_id = $index + 1;
                    $missionModel->save();
                }
            }
        }
    }

    private function setMissionProperties($index) {
        if ($this->currentMissionDt->getSpecificity() == LaunchSpecificity::Precise || $this->currentMissionDt->getSpecificity() == LaunchSpecificity::Day) {
            $this->mission->launch_exact = $this->scheduledLaunch;
            $this->mission->launch_approximate = null;
        } else {
            $this->mission->launch_approximate = $this->scheduledLaunch;
            $this->mission->launch_exact = null;
        }
        $this->mission->launch_order_id = $index+1;
        $this->mission->launch_specificity = $this->currentMissionDt->getSpecificity();
    }
}