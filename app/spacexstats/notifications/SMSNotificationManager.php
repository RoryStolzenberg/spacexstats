<?php

namespace SpaceXStats\Notifications;

use SpaceXStats\Enums\NotificationType;

class SMSNotificationManager extends NotificationManager {

    private $message = "SpaceX is launching %s aboard %s in %s at %s from %s. Watch live at webcast.spacex.com. More info at spacexstats.com/mission/%s.";

    public function notify() {
        // grab all users with this particular notification
    }
}