<?php

namespace SpaceXStats\Mail\Mailers;

use \User;

class UserMailer extends Mailer {

	public function welcome(User $user) {
		$view = 'emails.welcome';
		$data = ['email' => $user->email, 'key' => $user->key];
		$subject = 'Welcome to SpaceX Stats';

		$this->sendTo($user, $subject, $view, $data);
	}
}