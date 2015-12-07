<?php

namespace SpaceXStats\Mail\Mailers;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use SpaceXStats\Library\Enums\EmailStatus;
use SpaceXStats\Library\Enums\NotificationType;
use SpaceXStats\Models\Email;
use SpaceXStats\Models\User;

abstract class Mailer {

    /**
     * Sends email with the specified parameters for sending, once sent, add an Email model to the db
     *
     * @param User|Collection $user                     The user (or collection of users) the email is being sent to.
     * @param string $subject                           The subject of the email.
     * @param string $view                              The view template to use when creating the email.
     * @param array $data                               The data to pass into the view.
     * @param string $queue                             The queue to push the message onto for sending.
     * @param null|NotificationType $notificationType   An optional notification type to append to the DB
     */
    protected function sendTo($user, $subject, $view, $data = [], $queue = null, $notificationType = null) {

        // Fetch the type of class of User. We will take a different action depending on whether it
        // is a collection or just a single user
        $typeofUser = (new \ReflectionClass($user))->getShortName();

        // If it's just a single user, we queue it and send only the single email
        if ($typeofUser == 'User') {

            $this->sendEmail($user, $subject, $view, $data, $queue);

        // If it is a collection we immediately send an array of emails, and let Mailgun do the work
        } elseif ($typeofUser == 'Collection') {

            $this->sendEmails($user, $subject, $view, $data, $notificationType);
        }
	}

    private function sendEmail($user, $subject, $view, $data, $queue) {

        Mail::queueOn($queue, $view, $data, function($message) use($user, $subject) {
            $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
            $message->to($user->email)->subject($subject);
        });

        Email::create([
            'user_id' => $user->user_id,
            'subject' => $subject,
            'body' => view($view)->with($data)->render(),
            'status' => EmailStatus::Sent,
            'sent_at' => Carbon::now()
        ]);
    }

    private function sendEmails($users, $subject, $view, $data, $notificationType) {
        $userEmails = array_pluck($users->toArray(), 'email');

        Mail::send($view, $data, function($message) use ($userEmails, $subject) {
            $message->to($userEmails)->subject($subject);
        });

        $now = Carbon::now();

        $emails = $users->foreach(function($user) use ($now, $subject, $data, $view, $notificationType) {
            $email = new Email();
            $email->user_id = $user->user_id;
            $email->notification_id = $notificationType;
            $email->subject = $subject;
            $email->body = view($view)->with($data)->render();
            $email->status = EmailStatus::Sent;
            $email->sent_at = $email->created_at = $email->updated_at = $now;
        });

        Email::insert($emails);
    }
}