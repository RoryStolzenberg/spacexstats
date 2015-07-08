<?php
namespace SpaceXStats\MailQueues;

class MailQueue {
    public function queue($content, $action, $subscriptionType) {
        // Get the emails that are applicable to this and update them
        Email::where('status', 'Held')
            ->whereHas('emailSubscription.subscriptionType', function($q) use($subscriptionType, $content) {
                $q->where('name', $subscriptionType);
            })
            ->update(array(
                'content' => $content,
                'status' => $this->actionToEnum($action)
            ));

        // Get the email subscriptions which do not have a corresponding email and create them
        $subscriptionsWithNoCorrespondingHeldEmail = \EmailSubscriptions::whereHas('subscriptionType', function($q) use($subscriptionType) {
            $q->where('name', $subscriptionType);
        })->whereDoesntHave('emails', function($q) {
            $q->where('status', '=', 'Held');
        })->get();

        $subscriptionsWithNoCorrespondingHeldEmail->emails()->save(new Email(array(
            'content' => $content,
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