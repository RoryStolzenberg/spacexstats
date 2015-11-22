<?php
namespace SpaceXStats\Mail\MailQueues;

use SpaceXStats\Library\Enums\EmailStatus;
use SpaceXStats\Library\Enums\NotificationType;
use SpaceXStats\Models\Mission;

class MissionMailQueue extends MailQueue {
    public function newMission(Mission $mission) {
        $subject = "New SpaceX Mission: {$mission->name} has been added to the launch manifest.";
        $body = "Body text";
        $this->queue($subject, $body, NotificationType::NewMission, EmailStatus::Queued);
    }

    public function launchTimeChange(Mission $mission, $oldLaunchTime, $newLaunchTime, $emailStatus) {
        $subject = "SpaceX Launch Change: {$mission->name} rescheduled";
        $body = "Body text";
        $this->updateAndQueue($subject, $body, NotificationType::LaunchChange, $emailStatus);
    }
}