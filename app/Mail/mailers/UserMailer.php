<?php
namespace SpaceXStats\Mail\Mailers;

use SpaceXStats\Models\User;

class UserMailer extends Mailer {

    /**
     * Sends a welcome email to a user post-signup asking them to confirm their account to make it authenticated.
     *
     * @param User $user
     */
    public function welcome(User $user) {
        $queue = 'emails';
		$view = 'emails.welcome';
		$data = ['id' => $user->user_id, 'key' => $user->key];
		$subject = 'Welcome to SpaceX Stats';

		$this->sendTo($user, $subject, $view, $data, $queue);
	}
}