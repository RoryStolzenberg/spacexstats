<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Carbon\Carbon;
use SpaceXStats\Enums\UserRole;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, PresentableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	protected $primaryKey = 'user_id';
    public $timestamps = true;

	protected $hidden = ['password', 'remember_token'];
    protected $appends = [];
    protected $fillable = [];
	protected $guarded = ['role_id', 'username','email','password', 'key'];
	protected $dates = ['subscription_expiry'];

    protected $presenter = "UserPresenter";

	// Relations
    public function profile() {
		return $this->hasOne('Profile');
	}

	public function objects() {
		return $this->hasMany('Object');
	}

    public function favorites() {
        return $this->hasMany('Favorite');
    }

    public function notes() {
        return $this->hasMany('Note');
    }

    public function role() {
        return $this->belongsTo('Role');
    }

    public function notifications() {
        return $this->hasMany('Notification');
    }

    public function emails() {
        return $this->hasManyThrough('Email', 'Notification');
    }

    public function messages() {
        return $this->hasMany('Message');
    }

    public function comments() {
        return $this->hasMany('Comment');
    }

    // Conditional relations
    public function publishedObjects() {
        if (Auth::isAdmin()) {
            return $this->hasMany('Object')->where('status', \SpaceXStats\Enums\ObjectPublicationStatus::PublishedStatus);
        }
        return $this->hasMany('Object')
            ->where('status', \SpaceXStats\Enums\ObjectPublicationStatus::PublishedStatus)
            ->where('visibility', \SpaceXStats\Enums\VisibilityStatus::DefaultStatus);
    }

    public function unreadMessages() {
        return $this->hasMany('Message')->where('hasBeenRead', false);
    }

	// Helpers
	public function isValidForSignUp($input) {
		$rules = array(
			'username' => 'required|unique:users,username|min:3|alpha_dash|varchar:tiny',
			'email' => 'required|unique:users,email|email|varchar:tiny',
			'password' => 'required|confirmed|min:6',
            'eula' => 'required|accepted'
		);

        $messages = array(
            'eula.required' => 'Please confirm you agree with the End User License Agreement'
        );

		$validator = Validator::make($input, $rules, $messages);
		return $validator->passes() ? true : $validator->errors();
	}

	public function isValidForLogin() {
		$rules = array(
			'email' => 'required',
			'password' => 'required',
            'rememberMe' => 'boolean'
		);

        $user = User::where('email', Input::get('email'))->first();

        if ($user !== null && $user->role_id >= UserRole::Member) {
            return Auth::attempt(array(
                'email' => Input::get('email', null),
                'password' => Input::get('password', null)),
                Input::get('rememberMe', false)
            );
        } else {
            return false;
        }
	}

	public function isValidKey($email, $key) {
		$user = User::where('email', urldecode($email))->where('key', $key)->firstOrFail();
		if (!empty($user)) {
			$user->role_id = UserRole::Member;
			return $user->save();			
		}
	}

    public function setMobileDetails($number) {
        $this->attributes['mobile'] = $number->phone_number;
        $this->attributes['mobile_national_format'] = $number->national_format;
        $this->attributes['mobile_country_code'] = $number->country_code;
        $this->attributes['mobile_carrier'] = isset($number->carrier->name) ? $number->carrier->name : null;
    }

    public function resetMobileDetails() {
        $this->attributes['mobile'] = null;
        $this->attributes['mobile_national_format'] = null;
        $this->attributes['mobile_country_code'] = null;
        $this->attributes['mobile_carrier'] = null;
    }

	public function setPasswordAttribute($value) {
		$this->attributes['password'] = Hash::make($value);
	}

    // Attribute accessors
	public function getDaysUntilSubscriptionExpiresAttribute() {
		return Carbon::now()->diffInDays($this->subscription_expiry);
	}
}
