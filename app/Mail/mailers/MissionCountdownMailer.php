<?php

namespace SpaceXStats\Mail\Mailers;


use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Collection;
use SpaceXStats\Models\Mission;

class MissionCountdownMailer extends Mailer
{
    /**
     * Sends a collection of emails to those who should be receiving mission countdown notification enails.
     *
     * @param Collection $users             The collection of users who should be receiving this notification.
     * @param Mission $nextMission          The mission they are receiving the notification about.
     * @param CarbonInterval $timeToLaunch  The specific time to launch.
     */
    public function send($users, $nextMission, $timeToLaunch, $notificationType) {
        $view = 'emails.missionCountdown';
        $data = ['mission' => $nextMission, 'timeToLaunch' => $timeToLaunch];
        $subject = "SpaceXStats Countdown Notification: {$nextMission->name} launching in {$timeToLaunch}";

        $this->sendTo($users, $subject, $view, $data);
    }
}