<?php

namespace SpaceXStats\Notifications;

use Carbon\Carbon;
use SpaceXStats\Enums\LaunchSpecificity;
use SpaceXStats\Enums\NotificationType;

class NotificationManager {
    protected $domain, $now, $lastRun, $nextMission;

    public function __construct($domain) {
        $this->domain = $domain;

        $this->now = Carbon::now();
        $this->lastRun = $this->now->subMinute();

        $this->nextMission = \Mission::future()->first();
    }

    public function notificationIsNeeded() {
        if ($this->nextMission->launchSpecificity == LaunchSpecificity::Precise) {

            // Get the current difference in seconds
            $nowDiffInSeconds = $this->nextMission->launchDateTime->diffInSeconds($this->now);
            $lastRunDiffInSeconds = $this->nextMission->launchDateTime->diffInSeconds($this->lastRun);

            // determine if messages should be sent
            if ($nowDiffInSeconds < 86400 && $lastRunDiffInSeconds >= 86400 || $nowDiffInSeconds < 10800 && $lastRunDiffInSeconds >= 10800 && $nowDiffInSeconds < 3600 && $lastRunDiffInSeconds >= 3600) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function notify() {
        return null;
    }
}