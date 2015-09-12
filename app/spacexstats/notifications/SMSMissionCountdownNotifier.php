<?php

namespace SpaceXStats\Notifications;

use SpaceXStats\SMS\SMSSender;

class SMSMissionCountdownNotifier extends MissionCountdownNotifier {

    private $message = "SpaceX is launching %s aboard %s in %s at %s from %s. Watch live at webcast.spacex.com. More info at spacexstats.com/mission/%s.";

    public function notify() {
        // grab all users with this particular notification
        $usersToNotify = \User::whereHas('Notification', function($q) {
            $q->where('notification_type_id', $this->notificationType);
        })->with('notifications.notification_type')->get();

        // pad out message
        if ($this->timeRemaining->format('%h') == 24) {
            $timeRemainingString = "24 hours";
        } elseif ($this->timeRemaining->format('%h') == 3) {
            $timeRemainingString = "3 hours";
        } elseif ($this->timeRemaining->format('%h') == 1) {
            $timeRemainingString = "1 hour";
        }

        $messageToSend = sprintf($this->message,
            $this->nextMission->name, $this->nextMission->vehicle->vehicle, $timeRemainingString, $this->nextMission->launchDateTime, $this->nextMission->launchSite->fullLocation, $this->nextMission->slug);

        // Send!
        $sms = new SMSSender();
        $sms->send($usersToNotify, $messageToSend);
    }
}