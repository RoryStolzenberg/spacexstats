<?php

namespace SpaceXStats\Notifications;

use Carbon\Carbon;
use SpaceXStats\Enums\LaunchSpecificity;
use SpaceXStats\Enums\NotificationType;

abstract class MissionCountdownNotifier {
    protected $now, $lastRun, $nextMission, $notificationType, $timeRemaining;

    public function __construct() {
        $this->now = Carbon::now();
        $this->lastRun = $this->now->subMinute();

        $this->nextMission = \Mission::future()->first();
    }

    public function isNotificationNeeded() {
        if ($this->nextMission->launchSpecificity == LaunchSpecificity::Precise) {

            // Get the current difference in seconds
            $nowDiffInSeconds = $this->nextMission->launchDateTime->diffInSeconds($this->now);
            $lastRunDiffInSeconds = $this->nextMission->launchDateTime->diffInSeconds($this->lastRun);

            // determine if messages should be sent
            if ($nowDiffInSeconds < 86400 && $lastRunDiffInSeconds >= 86400) {
                $this->timeRemaining = \DateInterval::createFromDateString('24 hours');
                return true;
            } elseif ($nowDiffInSeconds < 10800 && $lastRunDiffInSeconds >= 10800) {
                $this->timeRemaining = \DateInterval::createFromDateString('3 hours');
                return true;
            } elseif ($nowDiffInSeconds < 3600 && $lastRunDiffInSeconds >= 3600) {
                $this->timeRemaining = \DateInterval::createFromDateString('1 hour');
                return true;
            }
            return false;
        }
        return false;
    }

    abstract public function notify();
}