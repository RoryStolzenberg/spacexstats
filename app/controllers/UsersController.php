<?php

use SpaceXStats\Mailers\UserMailer;
use SpaceXStats\Enums\UserRole;
use SpaceXStats\Enums\NotificationType;

class UsersController extends BaseController {

	protected $user, $mailer;

    protected $flashMessages = [
        'accountCouldNotBeCreatedDatabaseError'     => array('type' => 'failure', 'contents' => 'Looks like your account couldn\'t be created. You can try again, or get in touch.'),
        'accountCreated'                            => array('type' => 'success', 'contents' => 'Your account has been created, please check your email to activate your account!'),
        'accountCouldNotBeCreatedValidationError'   => array('type' => 'failure', 'contents' => 'Looks like your account couldn\'t be created. Check the errors below and then resubmit.'),
        'accountActivated'                          => array('type' => 'success', 'contents' => 'Your account has been activated!'),
        'accountCouldNotBeActivated'                => array('type' => 'failure', 'contents' => 'Your activation attempt was unsuccessful. Try again or get in touch.'),
        'failedLoginCredentials'                    => array('type' => 'failure', 'contents' => 'Your login attempt was unsuccessful. Try again.'),
        'failedLoginNotActivated'                   => array('type' => 'failure', 'contents' => 'Your login attempt was unsuccessful. Please check your email and activate your account first.')
    ];

	public function __construct(User $user, UserMailer $mailer) {
		$this->user = $user;
		$this->mailer = $mailer;
	}

	public function get($username) {
		$user = User::where('username', $username)->with(['objects', 'notes', 'favorites'])->first();

		// If a user was found
		if (!empty($user)) {

			//If the current user is logged in & If the current user is requesting themselves
			if (Auth::isAccessingSelf($user)) {
                return View::make('users.profile', array(
                    'user' => $user,
                    'favoriteMission' => $user->profile->favoriteMission,
                    'objects' => $user->objects->take(10),
                    'favorites' => $user->favorites->take(10),
                    'notes' => $user->notes
                ));
			} else {
                return View::make('users.profile', array(
                    'user' => $user,
                    'favoriteMission' => $user->profile->favoriteMission,
                    'objects' => $user->objects()->where('status', 'Published')->take(10),
                    'favorites' => $user->favorites->take(10),
                ));
			}

		// No user with that username was found
		} else {
			return Redirect::route('home');
			// 404
		}
	}

    public function edit($username) {
        $user = User::where('username', $username)->with('notifications.notificationType')->firstOrFail();

        $reflector = new ReflectionClass('SpaceXStats\Enums\NotificationType');
        $notificationTypes = $reflector->getConstants();

        $userNotifications = $user->notifications->keyBy('notification_type_id');

        $hasNotifications = [];
        foreach ($notificationTypes as $notificationKey => $notificationValue) {
            $hasNotifications[$notificationKey] = $userNotifications->has($notificationValue);
        }

        JavaScript::put([
            'missions' => Mission::with('featuredImage')->get(),
            'emailNotifications' => $hasNotifications,
            'profile' => $user->profile
        ]);

        return View::make('users.edit', array(
            'user' => $user,
        ));
    }

	public function editProfile($username) {
		$user = User::where('username', $username)->firstOrFail();

        if ($user->profile->fill(Input::only(['summary', 'twitter_account', 'reddit_account', 'favorite_mission', 'favorite_mission_patch', 'favorite_quote']))->save()) {
            return Response::json(['success' => true]);
        } else {
            return Response::json(['success' => false]);
        }
	}

    public function editEmailNotifications($username) {
        $user = User::where('username', $username)->with('notifications')->firstOrFail();

        $emailNotifications = Input::get('emailNotifications');

        foreach ($emailNotifications as $notificationType => $notificationValue) {
            //$user->notifications()->where('')
        }
    }

    public function editSMSNotifications($username) {
        $user = User::where('username', $username)->firstOrFail();

        //$client = new Lookups_Services_Twilio(Credential::TwilioSID, Credential::TwilioToken);
        //$number = $client->phone_numbers->get(Input::get('mobile'));

        /*$client = new Services_Twilio(Credential::TwilioSID, Credential::TwilioToken);
        $message = $client->account->messages->create(array(
            "From" => "+1 844-707-8834",
            "To" => '+64 021 280 4843',
            "Body" => 'SpaceX launching CRS-7 in 1 hour'
        ));*/

        return Response::json(true);
    }

    public function editRedditNotifications($username) {
        $user = User::where('username', $username)->firstOrFail();
    }

	public function create() {
		if (Request::isMethod('get')) {
			return View::make('users.signup');

		} elseif (Request::isMethod('post')) {

			$isValidForSignUp = $this->user->isValidForSignUp(Input::all());

			if ($isValidForSignUp === true) {

                DB::beginTransaction();
                try {
                    $user = new User();
                    $user->role_id  = UserRole::Unauthenticated;
                    $user->email    = Input::get('email', null);
                    $user->username = Input::get('username', null);
                    $user->password = Input::get('password', null);
                    $user->key      = str_random(32);
                    $user->save();

                    $profile = new Profile();
                    $profile->user()->associate($user)->save();

                    $this->mailer->welcome($user);

                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();

                    return Redirect::back()->with('flashMessage', $this->flashMessages['accountCouldNotBeCreatedDatabaseError']);
                }

				return Redirect::home()->with('flashMessage', $this->flashMessages['accountCreated']);
			} else {
				return Redirect::back()->withErrors($isValidForSignUp)->withInput(Input::except(['password', 'password_confirmation']))
                    ->with('flashMessage', $this->flashMessages['accountCouldNotBeCreatedValidationError']);
			}
		}
	}

	public function verify($email, $key) {
		if ($this->user->isValidKey($email, $key)) {
			return Redirect::route('users.login')
                ->with('flashMessage', $this->flashMessages['accountActivated']);
		} else {
			return Redirect::route('home')
                ->with('flashMessage', $this->flashMessages['accountCouldNotBeActivated']);
		}
	}

	public function login() {
		if (Request::isMethod('get')) {
			return View::make('users.login');

		} elseif (Request::isMethod('post')) {

			$isValidForLogin = $this->user->isValidForLogin();

			if ($isValidForLogin === true) {
				return Redirect::intended("/users/".Auth::user()->username);

			} elseif ($isValidForLogin === false) {
				return Redirect::back()
                    ->with('flashMessage', $this->flashMessages['failedLoginCredentials'])
                    ->withInput()
                    ->withErrors($isValidForLogin);

			} elseif ($isValidForLogin === 'authenticate') {
                return Redirect::back()
                    ->with('flashMessage', $this->flashMessages['failedLoginNotActivated']);
            }
		}
	}

    public function requestChangePassword() {

    }

    public function changePassword() {

    }

	public function logout() {
		Auth::logout();
		return Redirect::route('home');
	}
}