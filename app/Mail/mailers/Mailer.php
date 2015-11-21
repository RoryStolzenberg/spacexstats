<?php

namespace SpaceXStats\Mail\Mailers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use SpaceXStats\Models\User;

abstract class Mailer {
    /**
     * Sends email with the specified parameters for sending.
     *
     * @param User|Collection $user The user (or collection of users) the email is being sent to.
     * @param string $subject       The subject of the email.
     * @param string $view          The view template to use when creating the email.
     * @param array $data           The data to pass into the view.
     * @param string $queue         The queue to push the message onto for sending.
     */
    protected function sendTo($user, $subject, $view, $data = [], $queue = null) {

        // Fetch the type of class of User. We will take a different action depending on whether it
        // is a collection or just a single user
        $typeofUser = (new \ReflectionClass($user))->getShortName();

        // If it's just a single user, we queue it and send only the single email
        if ($typeofUser == 'User') {

            Mail::queueOn($queue, $view, $data, function($message) use($user, $subject) {
                $message->to($user->email)->subject($subject);
            });

        // If it is a collection we immediately send an array of emails, and let Mailgun do the work
        } elseif ($typeofUser == 'Collection') {

            $userEmails = array_pluck($user->toArray(), 'email');

            Mail::send($view, $data, function($message) use ($userEmails, $subject) {
                $message->to($userEmails)->subject($subject);
            });
        }
	}
}