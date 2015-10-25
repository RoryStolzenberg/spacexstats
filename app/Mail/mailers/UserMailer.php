<?php
namespace SpaceXStats\Mail\Mailers;

use SpaceXStats\Models\User;

class UserMailer extends Mailer {

	public function welcome(User $user) {
		$view = 'emails.welcome';
		$data = ['id' => $user->user_id, 'key' => $user->key];
		$subject = 'Welcome to SpaceX Stats';

		$this->sendTo($user, $subject, $view, $data);
	}
}