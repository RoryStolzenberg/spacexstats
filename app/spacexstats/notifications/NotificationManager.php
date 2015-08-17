<?php

namespace SpaceXStats\Notifications;

use Carbon\Carbon;
use SpaceXStats\Enums\LaunchSpecificity;
use SpaceXStats\Enums\NotificationType;

abstract class NotificationManager {
    protected $domain, $now, $lastRun, $nextMission, $notificationType;

    public function __construct($domain) {
        $this->domain = $domain;

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
                $this->tMinus = \DateInterval::createFromDateString('24 hours');
                return true;
            } elseif ($nowDiffInSeconds < 10800 && $lastRunDiffInSeconds >= 10800) {
                $this->tMinus = \DateInterval::createFromDateString('3 hours');
                return true;
            } elseif ($nowDiffInSeconds < 3600 && $lastRunDiffInSeconds >= 3600) {
                $this->tMinus = \DateInterval::createFromDateString('1 hour');
                return true;
            }
            return false;
        }
        return false;
    }

    abstract public function notify();
}