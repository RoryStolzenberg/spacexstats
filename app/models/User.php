<?php
namespace SpaceXStats\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;

use SpaceXStats\Library\Enums\ObjectPublicationStatus;
use SpaceXStats\Library\Enums\UserRole;
use SpaceXStats\Library\Enums\VisibilityStatus;
use SpaceXStats\Presenters\Traits\PresentableTrait;
use SpaceXStats\Presenters\UserPresenter;

use Auth;
use Hash;
use Input;
use SpaceXStats\Services\DeltaVCalculator;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, BillableContract
{
    use Authenticatable, Authorizable, CanResetPassword, Billable, PresentableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = true;

    protected $hidden = ['password', 'remember_token', 'email', 'mobile_national_format', 'mobile_country_code', 'mobile_carrier', 'subscription_expiry', 'key', 'last_login'];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = ['role_id', 'username','email','password', 'key'];
    protected $dates = ['subscription_ends_at', 'trial_ends_at'];

    protected $presenter = UserPresenter::class;

    // Relations
    public function profile() {
        return $this->hasOne('SpaceXStats\Models\Profile');
    }

    public function objects() {
        return $this->hasMany('SpaceXStats\Models\Object');
    }

    public function favorites() {
        return $this->hasMany('SpaceXStats\Models\Favorite');
    }

    public function notes() {
        return $this->hasMany('SpaceXStats\Models\Note');
    }

    public function role() {
        return $this->belongsTo('SpaceXStats\Models\Role');
    }

    public function notifications() {
        return $this->hasMany('SpaceXStats\Models\Notification');
    }

    public function emails() {
        return $this->hasMany('SpaceXStats\Models\Email'); // Could also be retrieved by 'hasManyThrough' notifications
    }

    public function messages() {
        return $this->hasMany('SpaceXStats\Models\Message');
    }

    public function comments() {
        return $this->hasMany('SpaceXStats\Models\Comment');
    }

    public function awards() {
        return $this->hasMany('SpaceXStats\Models\Award');
    }

    public function payments() {
        return $this->hasMany('SpaceXStats\Models\Payment');
    }

    // Conditional relations
    public function objectsInMissionControl() {
        if (Auth::isAdmin()) {
            return $this->hasMany('SpaceXStats\Models\Object')->where('status', ObjectPublicationStatus::PublishedStatus);
        }
        return $this->hasMany('SpaceXStats\Models\Object')
            ->where('status', ObjectPublicationStatus::PublishedStatus)
            ->where('visibility', '!=', VisibilityStatus::HiddenStatus);
    }

    public function unreadMessages() {
        return $this->hasMany('SpaceXStats\Models\Message')->where('is_read', false);
    }

    // Helpers
    public function isValidKey($userId, $key) {
        $user = User::where('user_id', $userId)->where('key', $key)->firstOrFail();

        if (!empty($user)) {
            $user->role_id = UserRole::Member;
            return $user->save();
        }
    }

    public function isLaunchController() {
        return $this->launch_controller_flag == true;
    }

    public function totalDeltaV() {
        return $this->awards()->sum('value');
    }

    public function subscriptionExtendedBy($pretty = false) {
        $secondsExtended = (new DeltaVCalculator())->toSeconds($this->totalDeltaV());

        return $pretty ? CarbonInterval::seconds($secondsExtended) : $secondsExtended;
    }

    public function setMobileDetails($number) {
        $this->mobile = $number->phone_number;
        $this->mobile_national_format = $number->national_format;
        $this->mobile_country_code = $number->country_code;
        $this->mobile_carrier = isset($number->carrier->name) ? $number->carrier->name : null;
    }

    public function resetMobileDetails() {
        $this->mobile = null;
        $this->mobile_national_format = null;
        $this->mobile_country_code = null;
        $this->mobile_carrier = null;
    }

    // Attribute accessors
    // Attribute mutators
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }

    // Scope
    public function scopeByUsername($q, $username) {
        return $q->where('username', $username)->firstOrFail();
    }
}
