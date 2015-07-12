<?php
namespace SpaceXStats\MailQueues;

class MailQueue {

    public function queue($content, $notificationType) {
        $notificationsToQueueEmailsFor = \Notification::where('notification_type_id', $notificationType)->get();

        foreach ($notificationsToQueueEmailsFor as $notification) {
            $email = new \Email();
            $email->notification()->associate($notification);
            $email->content = $content;
            $email->status = 'Queued';
            $email->save();
        }
    }

    //
    public function updateAndQueue($content, $notificationType, $action) {
        // Get the emails that are applicable to this subscription and update them
        Email::where('status', 'Held')
            ->whereHas('notification.notificationType', function($q) use($notificationType, $content) {
                $q->where('name', $notificationType);
            })
            ->update(array(
                'content' => $content,
                'status' => $this->actionToEnum($action)
            ));

        // Get the email subscriptions which do not have a corresponding email and create them
        $notificationsWithNoCorrespondingHeldEmail = \Notification::whereHas('notificationType', function($q) use($notificationType) {
            $q->where('name', $notificationType);
        })->whereDoesntHave('emails', function($q) {
            $q->where('status', '=', 'Held');
        })->get();

        $notificationsWithNoCorrespondingHeldEmail->emails()->save(new \Email(array(
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