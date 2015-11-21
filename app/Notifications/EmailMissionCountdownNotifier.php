<?php

namespace SpaceXStats\Notifications;


use SpaceXStats\Library\Enums\NotificationType;
use SpaceXStats\Mail\Mailers\MissionCountdownMailer;
use SpaceXStats\Models\Email;

class EmailMissionCountdownNotifier extends MissionCountdownNotifier {

    public function notify() {
        // What notification type is this
        if ($this->timeRemaining->hours == 24) {
            $notificationType = NotificationType::TMinus24HoursEmail;
        } elseif ($this->timeRemaining->hours == 3) {
            $notificationType = NotificationType::TMinus3HoursEmail;
        } else {
            $notificationType = NotificationType::TMinus1HourEmail;
        }

        // grab all users with this particular notification
        $usersToNotify = User::whereHas('notification', function($q) use ($notificationType) {
            $q->where('notification_type_id', $notificationType);
        })->with('notifications.notification_type')->get();

        // Prepare to send
        $missionCountdownMailer = new MissionCountdownMailer();
        $missionCountdownMailer->send($usersToNotify, $this->nextMission, $this->timeRemaining, $notificationType);
    }
}