<?php 
 namespace SpaceXStats\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Lookups_Services_Twilio;
use Services_Twilio_RestException;
use SpaceXStats\Library\Enums\NotificationType;
use SpaceXStats\Mail\Mailers\UserMailer;
use SpaceXStats\Models\Mission;
use SpaceXStats\Models\Notification;
use SpaceXStats\Models\User;
use JavaScript;
use SpaceXStats\Services\DeltaVCalculator;


class UsersController extends Controller {

	protected $user, $mailer;

	public function __construct(User $user, UserMailer $mailer) {
		$this->user = $user;
        $this->mailer = $mailer;
	}

	public function get(DeltaVCalculator $deltaV, $username = null) {
        $user = User::where('username', $username)->with(['objects', 'notes', 'favorites'])->first();

        $params = array(
            'user' => $user,
            'favoriteMission' => $user->profile->favoriteMission,
            'objects' => $user->objects()->inMissionControl()->take(10)->get(),
            'favorites' => $user->favorites->take(10),
            'comments' => $user->comments->take(10),
            'subscriptionExtendedBy' => $user->subscriptionExtendedBy(true)
        );

        // If the requesting user is logged in & if the requesting user is requesting themselves
        if (Auth::isAccessingSelf($user)) {
            $params['notes'] = $user->notes->take(10);
        }

        return view('users.profile', $params);
	}

    public function getEdit($username) {
        $user = User::where('username', $username)->with(['notifications.notificationType', 'profile'])->firstOrFail();

        $notificationTypes = NotificationType::toArray();
        $userNotifications = $user->notifications->keyBy('notification_type_id');

        $hasNotifications = [];
        foreach ($notificationTypes as $notificationKey => $notificationValue) {
            $hasNotifications[$notificationKey] = $userNotifications->has($notificationValue);
        }

        JavaScript::put([
            'missions' => Mission::with('featuredImage')->get(),
            'patches' => Mission::whereNotNull('mission_patch')->with('missionPatch')->get(),
            'notifications' => $hasNotifications,
            'user' => $user
        ]);

        return view('users.edit', array(
            'user' => $user,
        ));
    }

	public function patchEditProfile($username) {
		$user = User::where('username', $username)->firstOrFail();

        if ($user->profile->fill(Input::only(['summary', 'twitter_account', 'reddit_account', 'favorite_mission', 'favorite_mission_patch', 'favorite_quote']))->save()) {
            return response()->json(Lang::get('profile.updated'));
        } else {
            return response()->json(Lang::get('global.somethingWentWrong'));
        }
	}

    public function editEmailNotifications($username) {
        $user = User::where('username', $username)->with('notifications.notificationType')->firstOrFail();
        $currentNotificationsForUser = $user->notifications->keyBy('notification_type_id');

        $emailNotifications = Input::get('emailNotifications');

        foreach ($emailNotifications as $notificationType => $notificationValue) {
            if ($notificationValue === true) {

                // Check if that notification type does not exist for that user, create notification
                if (!$currentNotificationsForUser->has(SpaceXStats\Library\Enums\NotificationType::fromString($notificationType))) {
                    $notification = new Notification();
                    $notification->user()->associate($user);
                    $notification->notification_type_id = SpaceXStats\Library\Enums\NotificationType::fromString($notificationType);
                    $notification->save();
                }

            } else {

                // Check if that notification type exists for that user, if yes, (soft) delete
                if ($currentNotificationsForUser->has(NotificationType::fromString($notificationType))) {
                    $currentNotificationsForUser->get(NotificationType::fromString($notificationType))->first()->delete();
                }
            }
        }

        return response()->json(Lang::get('profile.email.succeeded'));
    }

    public function editSMSNotifications($username) {
        $user = User::where('username', $username)->with('notifications.notificationType')->firstOrFail();
        $sms = Input::get('SMSNotification');

        // Delete any previous SMS notification
        Notification::where('user_id', $user->user_id)
            ->whereIn('notification_type_id', array(
                NotificationType::tMinus24HoursSMS,
                NotificationType::tMinus3HoursSMS,
                NotificationType::tMinus1HourSMS
            ))->delete();

        // If the number is blank, assume the user wants their SMS setup deleted
        if ($sms['mobile'] == "") {
            $user->resetMobileDetails();
            $user->save();
            return response()->json(Lang::get('profile.sms.succeeded'));
        }

        // If status is not false
        if ($sms['status'] != 'false') {

            // Because Twilio
            $client = new Lookups_Services_Twilio(Config::get('services.twilio.sid'), Config::get('services.twilio.token'));

            // Try to see if the number exists, if not, will throw exception
            try {
                $number = $client->phone_numbers->get($sms['mobile']);

                // Check for errors
                if (!isset($number->status)) {
                    // Set user mobile details
                    $user->setMobileDetails($number);
                    $user->save();

                    // Insert new notification
                    Notification::create(array(
                        'user_id' => Auth::id(),
                        'notification_type_id' => NotificationType::fromString($sms['status'])
                    ));

                    return response()->json(Lang::get('profile.sms.succeeded'));
                }
                return response()->json(Lang::get('global.somethingWentWrong'), 500);

            } catch (Services_Twilio_RestException $e) {
                return response()->json(Lang::get('profile.sms.failed'), 400);
            }
        }
        return response()->json(Lang::get('profile.sms.succeeded'));
    }

    public function editRedditNotifications($username) {
        $user = User::where('username', $username)->firstOrFail();
    }

    // GET: /users/{username}/favorites
    public function favorites($username) {
        $user = User::where('username', $username)->first();

        return view('users.profile.favorites', array(
            'user' => $user,
            'favorites' => Favorite::where('user_id', $user)->with('object')->get()
        ));
    }

    // GET: /users/{username}/notes
    public function notes($username) {
        $user = User::where('username', $username)->first();

        return view('users.profile.notes', array(
            'user' => $user,
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

        return view('users.profile.comments', array(
            'user' => $user,
            'favorites' => Comment::where('user_id', $user)->with('object')->get()
        ));
    }
}