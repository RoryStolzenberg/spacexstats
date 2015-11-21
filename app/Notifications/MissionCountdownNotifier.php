<?php

namespace SpaceXStats\Notifications;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use SpaceXStats\Library\Enums\LaunchSpecificity;
use SpaceXStats\Models\Mission;

abstract class MissionCountdownNotifier {
    protected $now, $lastRun, $nextMission, $timeRemaining;

    public function __construct() {
        $this->now = Carbon::now();
        $this->lastRun = $this->now->subMinute();

        $this->nextMission = Mission::future()->first();
    }

    public function isNotificationNeeded() {
        // If the next mission has a precise launch specificity (allowing us to accurately calculate times)
        if ($this->nextMission->launchSpecificity == LaunchSpecificity::Precise) {

            // Get the current difference in seconds between now (and the last time this method was called, which is always 1 minute
            // earlier because the MissionCountdownNotificationCommand is a 1 minute repeating cronjob)), and the scheduled launch
            // datetime.
            $nowDiffInSeconds = $this->nextMission->launchDateTime->diffInSeconds($this->now);
            $lastRunDiffInSeconds = $this->nextMission->launchDateTime->diffInSeconds($this->lastRun);

            // is it less than 1 day to launch now, and it was greater before?
            if ($nowDiffInSeconds < 86400 && $lastRunDiffInSeconds >= 86400) {
                $this->timeRemaining = CarbonInterval::hours(24);
                return true;

            // it is less than 3 hours to launch now, and it was greater before?
            } elseif ($nowDiffInSeconds < 10800 && $lastRunDiffInSeconds >= 10800) {
                $this->timeRemaining = CarbonInterval::hours(3);
                return true;

            // is it less than 1 hour to launch now, and it was greater before?
            } elseif ($nowDiffInSeconds < 3600 && $lastRunDiffInSeconds >= 3600) {
                $this->timeRemaining = CarbonInterval::hours(1);
                return true;
            }
        }
        return false;
    }

    abstract public function notify();
}