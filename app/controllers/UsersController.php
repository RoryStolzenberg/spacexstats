<?php

use SpaceXStats\Mailers\UserMailer;
use SpaceXStats\Enums\UserRole;

class UsersController extends BaseController {
	protected $user, $mailer; 

	public function __construct(User $user, UserMailer $mailer) {
		$this->user = $user;
		$this->mailer = $mailer;
	}

	public function get($username) {
		$user = User::where('username', $username)->first();
		// If a user was found
		if (!empty($user)) {
			//If the current user is logged in & If the current user is requesting themselves
			if (Auth::isAccessingSelf($user)) {
				$objects = Object::where('user_id',$user->user_id)->get();
			} else {
				$objects = Object::where('user_id',$user->user_id)->where('status','Published')->where('association',true)->get();
			}
			return View::make('users.profile', array(
				'user' => $user,
				'objects' => $objects,
				'favoriteMission' => Mission::find($user->profile->favorite_mission)
			));
		// No user with that username was found
		} else {
			return Redirect::route('home');
			// 404
		}
	}

	public function edit($username) {
		$user = User::where('username', $username)->with('profile')->firstOrFail();
		
		if (Request::isMethod('get')) {			
			return View::make('users.edit', array(
				'user' => $user,
				'profile' => $user->profile,
				'missions' => Mission::all()
			));

		} elseif (Request::isMethod('post')) {
			if ($user->profile->fill(Input::all())->save()) {
				return Response::json(['success' => true]);
			} else {
				return Response::json(['success' => false]);
			}
		}
	}

	public function create() {
		if (Request::isMethod('get')) {
			return View::make('users.signup');

		} elseif (Request::isMethod('post')) {

			$isValidForSignUp = $this->user->isValidForSignUp(Input::all());

			if ($isValidForSignUp === true) {
				$user = User::create(array(
						'role_id' => UserRole::Unauthenticated,
						'email' => Input::get('email', null),
						'username' => Input::get('username', null),
						'password' => Input::get('password', null),
						'key' => str_random(32)
					));

                //DB::transaction(function() {
                //    $user = new User();
                //    $user->role_id()->associate(UserRole::Unauthenticated);
                //});

                //$user = new User();



				$profile = new Profile;
				$profile->user()->associate($user)->save();

				$this->mailer->welcome($user);

				return Redirect::home()->with('flashMessage', array('contents' => 'Your account has been created, please check your email to activate your account!', 'type' => 'success'));
			} else {
				return Redirect::back()->withErrors($isValidForSignUp)->withInput();
			}
		}
	}

	public function verify($email, $key) {
		if ($this->user->isValidKey($email, $key)) {
			return Redirect::route('users.login')
                ->with('flashMessage', array('contents' => 'Your account has been activated!', 'type' => 'success'));
		} else {
			return Redirect::route('home')
                ->with('flashMessage', array('contents' => 'Your activation attempt was unsuccessful. Try again or get in touch.', 'type' => 'failure'));
		}
	}

	public function login() {
		if (Request::isMethod('get')) {
			return View::make('users.login');

		} elseif (Request::isMethod('post')) {

			$isValidForLogin = $this->user->isValidForLogin();

			if ($isValidForLogin) {
				return Redirect::intended("/users/".Auth::user()->username);
			} else {
				return Redirect::back()
                    ->with('flashMessage', array('contents' => 'Your login attempt was unsuccessful. Try again.', 'type' => 'failure'))
                    ->withInput()
                    ->withErrors($isValidForLogin);
			}
		}
	}

	public function logout() {
		Auth::logout();
		return Redirect::route('home');
	}
}