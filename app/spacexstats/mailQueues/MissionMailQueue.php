<?php
namespace SpaceXStats\MailQueues;

use SpaceXStats\Enums\EmailSubscription;

class MissionMailQueue {
    public function newMission(\Mission $mission, $action) {
        if ($action == 'Queue') {

            // Get the users with this subscription type
            $users = User::whereHas('emailSubscriptions.subscriptionType', function($q) {
                $q->where('name', 'New Mission');
            })->get();
        } elseif ($action == 'Hold') {

        }
    }
}