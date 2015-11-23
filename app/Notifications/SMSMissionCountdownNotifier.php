<?php

namespace SpaceXStats\Notifications;

use SpaceXStats\Library\Enums\NotificationType;
use SpaceXStats\Models\User;
use SpaceXStats\SMS\SMSSender;

class SMSMissionCountdownNotifier extends MissionCountdownNotifier {

    private $message = "SpaceX is launching %s aboard %s in %s at %s UTC from %s. Watch live at spacexstats.com/live. More info at spacexstats.com/missions/%s.";

    public function notify() {
        // What notification type is this
        if ($this->timeRemaining->hours == 24) {
            $notificationType = NotificationType::TMinus24HoursSMS;
        } elseif ($this->timeRemaining->hours == 3) {
            $notificationType = NotificationType::TMinus3HoursSMS;
        } else {
            $notificationType = NotificationType::TMinus1HourSMS;
        }

        // grab all users with this particular notification
        $usersToNotify = User::whereHas('notification', function($q) use ($notificationType) {
            $q->where('notification_type_id', $notificationType);
        })->with('notifications.notification_type')->get();

        $messageToSend = sprintf($this->message,
            $this->nextMission->name, $this->nextMission->vehicle->vehicle, $this->timeRemaining, $this->nextMission->launchDateTime, $this->nextMission->launchSite->fullLocation, $this->nextMission->slug);

        // Send!
        $sms = new SMSSender();
        $sms->send($usersToNotify, $messageToSend);
    }
}