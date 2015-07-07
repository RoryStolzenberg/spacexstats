<?php
namespace SpaceXStats\MailQueues;

use SpaceXStats\Enums\EmailSubscription;

class MissionMailQueue {
    public function newMission(\Mission $mission, $action) {

            // Get the emails that are applicable to this and update them
            Email::where('status', 'Held')
                ->whereHas('emailSubscription.subscriptionType', function($q) {
                    $q->where('name', 'New Mission');
                })
                ->update(array(
                    'content' => 'txt',
                    'status' => $this->actionToEnum($action)
                ));

            // Get the email subscriptions which do not have a corresponding email and create them
            $subscriptionsWithNoCorrespondingHeldEmail = EmailSubscriptions::whereHas('subscriptionType', function($q) {
                $q->where('name', 'New Mission');
            })->whereDoesntHave('emails', function($q) {
                $q->where('status', '=', 'Held');
            })->get();

            $subscriptionsWithNoCorrespondingHeldEmail->emails()->save(new Email(array(
                 'content' => 'txt',
                'status' => $this->actionToEnum($action)
            )));
    }

    private function actionToEnum($action) {
        if ($action == 'Queue') {
            return 'Queued';
        } elseif ($action == 'Hold') {
            return 'Held';
        }
    }
}