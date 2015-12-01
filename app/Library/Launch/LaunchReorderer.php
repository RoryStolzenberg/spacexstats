<?php
namespace SpaceXStats\Library\Launch;

use SpaceXStats\Library\Enums\LaunchSpecificity;
use SpaceXStats\Models\Mission;

class LaunchReorderer {
	protected $mission, $scheduledLaunch, $currentLaunchOrderId;

	public function __construct(Mission $currentMissionReference, $scheduledLaunch) {
        $this->mission = $currentMissionReference;
        $this->scheduledLaunch = $scheduledLaunch;
        $this->currentMissionDt = LaunchDateTimeResolver::parseString($scheduledLaunch);
	}

    // Returns a launch date time instance
	public function run() {

        // Grab all missions as an array, pass them through
        if (is_null($this->mission->mission_id)) {
            $allMissions = Mission::orderBy('launch_order_id', 'ASC')->get();
        } else {
            $allMissions = Mission::where('mission_id', '!=', $this->mission->mission_id)->orderBy('launch_order_id', 'ASC')->get();
        }

        $arrayedMissions = $allMissions->toArray();

        // Add the mission we are running from to the array
        array_push($arrayedMissions, array('context' => true, 'launch_date_time' => $this->scheduledLaunch));

        // Sort the missions by launchDateTime
        // Use the at symbol because http://stackoverflow.com/a/10985500/1064923
        @usort($arrayedMissions, function($a, $b) {
            $ldta = LaunchDateTimeResolver::parseString($a['launch_date_time']);
            $ldtb = LaunchDateTimeResolver::parseString($b['launch_date_time']);

            return LaunchDateTime::compare($ldta, $ldtb);
        });

        // Update each mission's launch_order_id
        foreach ($arrayedMissions as $index => $arrayedMission) {
            // If the context is from the current mission, set the current mission properties
            if (array_key_exists('context', $arrayedMission)) {
                $this->setMissionProperties($index);
                $this->mission->save();

            // Else, update the mission properties if it needs updating
            } else {
                // Check to see if it actually needs updating in the db
                if ($arrayedMission['launch_order_id'] !== $index + 1) {
                    $missionModel = $allMissions->first(function($key, $value) use ($arrayedMission) {
                        return $value->launch_order_id == $arrayedMission['launch_order_id'];
                    });
                    $missionModel->launch_order_id = $index + 1;
                    $missionModel->save();
                }
            }
        }
    }

    private function setMissionProperties($index) {
        if ($this->currentMissionDt->isPrecise()) {
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