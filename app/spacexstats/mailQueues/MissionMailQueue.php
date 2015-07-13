<?php
namespace SpaceXStats\MailQueues;

use SpaceXStats\Enums\NotificationType;

class MissionMailQueue extends MailQueue {
    public function newMission(\Mission $mission) {
        $subject = "New SpaceX Mission: {$mission->name}, launching {$mission->launchDateTime}";
        $body = "Body text";
        $this->queue($subject, $body, NotificationType::newMission);
    }

    public function launchTimeChange(\Mission $mission) {

    }

    public function tMinus24Hours(\Mission $mission) {

    }

    public function tMinus3Hours(\Mission $mission) {

    }

    public function tMinus1Hour(\Mission $mission) {

    }


}