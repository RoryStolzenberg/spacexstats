<?php

use SpaceXStats\Mail\Mailers\UserMailer;
use SpaceXStats\Enums\UserRole;
use SpaceXStats\Enums\NotificationType;

class UsersController extends BaseController {

	protected $user, $mailer;

    protected $flashMessages = [
        'accountCouldNotBeCreatedDatabaseError'     => array('type' => 'failure', 'contents' => 'Looks like your account couldn\'t be created. You can try again, or get in touch.'),
        'accountCreated'                            => array('type' => 'success', 'contents' => 'Your account has been created, please check your email to activate your account!'),
        'accountCouldNotBeCreatedValidationError'   => array('type' => 'failure', 'contents' => 'Looks like your account couldn\'t be created. Check the errors below and then resubmit.'),
        'accountActivated'                          => array('type' => 'success', 'contents' => 'Your account has been activated!'),
        'accountCouldNotBeActivated'                => array('type' => 'failure', 'contents' => 'Your activation attempt was unsuccessful.  You can try again, or get in touch.'),
        'failedLoginCredentials'                    => array('type' => 'failure', 'contents' => 'Your login attempt was unsuccessful. Try again.'),
        'failedLoginNotActivated'                   => array('type' => 'failure', 'contents' => 'Your login attempt was unsuccessful. Please check your email and activate your account first.'),
        'somethingWentWrong'                        => array('type' => 'failure', 'contents' => 'Something went wrong. You can try again, or get in touch.'),
        'SMSNotificationSuccess'                    => array('type' => 'success', 'contents' => 'SMS Notification settings updated!'),
        'updateProfileSuccess'                      => array('type' => 'success', 'contents' => 'Profile settings updated!'),
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
        $user = User::where('username', $username)->with(['notifications.notificationType', 'profile'])->firstOrFail();

        $notificationTypes = SpaceXStats\Enums\NotificationType::toArray();
        $userNotifications = $user->notifications->keyBy('notification_type_id');

        $hasNotifications = [];
        foreach ($notificationTypes as $notificationKey => $notificationValue) {
            $hasNotifications[$notificationKey] = $userNotifications->has($notificationValue);
        }

        JavaScript::put([
            'missions' => Mission::with('featuredImage')->get(),
            'notifications' => $hasNotifications,
            'user' => $user
        ]);

        return View::make('users.edit', array(
            'user' => $user,
        ));
    }

	public function editProfile($username) {
		$user = User::where('username', $username)->firstOrFail();

        if ($user->profile->fill(Input::only(['summary', 'twitter_account', 'reddit_account', 'favorite_mission', 'favorite_mission_patch', 'favorite_quote']))->save()) {
            return Response::json($this->flashMessages['updateProfileSuccess']);
        } else {
            return Response::json($this->flashMessages['somethingWentWrong']);
        }
	}

    public function editEmailNotifications($username) {
        $user = User::where('username', $username)->with('notifications')->firstOrFail();

        $emailNotifications = Input::get('emailNotifications');

        foreach ($emailNotifications as $notificationType => $notificationValue) {
            if ($notificationValue === true) {
                // Check if that notification type exists for that user
                    // If yes, do nothing
                    // If no, create notification
            } else {
                // Check if that notification type exists for that user
                    // If yes, delete (soft delete)
                    // If no, do nothing
            }
        }
    }

    public function editSMSNotifications($username) {
        $user = User::where('username', $username)->with('notifications.notificationType')->firstOrFail();

        $sms = Input::get('SMSNotification');

        // Delete any previous SMS notification
        $oldSMSNotification = Notification::where('user_id', $user->user_id)
            ->where('notification_type_id', NotificationType::tMinus24HoursSMS)
            ->orWhere('notification_type_id', NotificationType::tMinus3HoursSMS)
            ->orWhere('notification_type_id', NotificationType::tMinus1HourSMS)
            ->delete();

        // Check if new status is not null
        if ($sms['status'] != null) {

            $client = new Lookups_Services_Twilio(Credential::TwilioSID, Credential::TwilioToken);
            $number = $client->phone_numbers->get($sms['mobile']);

            // Check for errors
            if (!isset($number->status)) {

                // Set user mobile details
                $user->setMobileDetails($number);
                $user->save();

                // Insert new notification
                Notification::create(array(
                    'user_id' => Auth::user()->user_id,
                    'notification_type_id' => NotificationType::fromString($sms['status'])
                ));

                return Response::json($this->flashMessages['SMSNotificationSuccess']);
            }
            return Response::json($this->flashMessages['SMSNotificationFailure']);
        }

        $user->resetMobileDetails();
        $user->save();

        return Response::json($this->flashMessages['SMSNotificationSuccess']);
    }

    public function editRedditNotifications($username) {
        $user = User::where('username', $username)->firstOrFail();
    }

    // GET: /users/{username}/favorites
    public function favorites($username) {
        $user = User::where('username', $username)->first();

        return View::make('users.favorites', array(
            'favorites' => Favorite::where('user_id', $user)->with('object')->get()
        ));
    }

    // GET: /users/{username}/notes
    public function notes($username) {
        $user = User::where('username', $username)->first();

        return View::make('users.favorites', array(
            'favorites' => Note::where('user_id', $user)->with('object')->get()
        ));
    }

    // GET: /users/{username}/uploads
    public function uploads($username) {
        // is admin
    }

    // GET: /users/{username}/comments
    public function comments($username) {
        $user = User::where('username', $username)->first();

        return View::make('users.favorites', array(
            'favorites' => Comment::where('user_id', $user)->with('object')->get()
        ));
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