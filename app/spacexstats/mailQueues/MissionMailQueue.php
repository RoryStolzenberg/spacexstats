<?php
namespace SpaceXStats\MailQueues;

use SpaceXStats\Enums\NotificationType;

class MissionMailQueue extends MailQueue {
    public function newMission(\Mission $mission, $action) {
        $this->queue("text", NotificationType::newMission);
    }
}