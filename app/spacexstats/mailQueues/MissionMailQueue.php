<?php
namespace SpaceXStats\MailQueues;

class MissionMailQueue extends MailQueue {
    public function newMission(\Mission $mission, $action) {
        $this->queue("text", $action, 'New Mission');
    }
}