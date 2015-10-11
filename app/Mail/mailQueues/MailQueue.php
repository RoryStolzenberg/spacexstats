<?php
namespace SpaceXStats\Mail\MailQueues;

use SpaceXStats\Library\Enums\EmailStatus;
use SpaceXStats\Models\Email;
use SpaceXStats\Models\Notification;

abstract class MailQueue {

    public function queue($subject, $body, $notificationType, $action) {
        $notificationsToQueueEmailsFor = Notification::where('notification_type_id', $notificationType)->get();

        foreach ($notificationsToQueueEmailsFor as $notification) {
            $email = new Email();
            $email->notification()->associate($notification);
            $email->subject = $subject;
            $email->body = $body;
            $email->status = $action;
            $email->save();
        }
    }

    //
    public function updateAndQueue($subject, $body, $notificationType, $action) {
        // Get the emails that are applicable to this subscription and update them
        Email::where('status', 'Held')
            ->whereHas('notification.notificationType', function($q) use($notificationType, $body, $subject) {
                $q->where('name', $notificationType);
            })
            ->update(array(
                'content' => $subject,
                'body' => $body,
                'status' => $action
            ));

        // Get the email subscriptions which do not have a corresponding email and create them
        $notificationsWithNoCorrespondingHeldEmail = Notification::whereHas('notificationType', function($q) use($notificationType) {
            $q->where('name', $notificationType);
        })->whereDoesntHave('emails', function($q) {
            $q->where('status', '=', EmailStatus::Held);
        })->get();

        $notificationsWithNoCorrespondingHeldEmail->emails()->save(new \Email(array(
            'subject' => $subject,
            'body' => $body,
            'status' => $action
        )));
    }
}