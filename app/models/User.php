<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Carbon\Carbon;
use SpaceXStats\Library\Enums\UserRole;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = true;

    protected $hidden = ['password', 'remember_token', 'email', 'mobile', 'mobile_national_format', 'mobile_country_code', 'mobile_carrier', 'subscription_expiry', 'key', 'last_login'];
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

    public function awards() {
        return $this->hasMany('Award');
    }

    // Conditional relations
    public function publishedObjects() {
        if (Auth::isAdmin()) {
            return $this->hasMany('Object')->where('status', ObjectPublicationStatus::PublishedStatus);
        }
        return $this->hasMany('Object')
            ->where('status', ObjectPublicationStatus::PublishedStatus)
            ->where('visibility', VisibilityStatus::DefaultStatus);
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

    /**
     * Increment the user's Mission Control subscription by the given number of seconds if they are a
     * Mission Control subscriber.
     *
     * @param $secondsToIncrement   integer     The number of seconds to increment a user subscription by.
     */
    public function incrementSubscription($secondsToIncrement) {
        if ($this->role_id == UserRole::Subscriber) {
            $this->subscription_expiry->addSeconds($secondsToIncrement);
        }
    }

    // Attribute accessors
    public function getDaysUntilSubscriptionExpiresAttribute() {
        return Carbon::now()->diffInDays($this->subscription_expiry);
    }

    // Attribute mutators
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }
}
