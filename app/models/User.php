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

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];
    protected $appends = [];
    protected $fillable = [];
	protected $guarded = ['role_id', 'username','email','password', 'key'];
	protected $dates = ['subscription_expiry'];

    protected $presenter = "UserPresenter";

	// Relations
	//public function role() {
	//	return $this->belongsTo('Role');
	//}

	public function profile() {
		return $this->hasOne('Profile');
	}

	public function objects() {
		return $this->hasMany('Object');
	}

	public function publishedObjects() {
		return $this->hasMany('Object')->where('status','Published');
	}

	public function favorites() {
		return $this->hasMany('Favorite');
	}

    public function role() {
        return $this->belongsTo('Role');
    }

	// Helpers
	public function isValidForSignUp($input) {
		$rules = array(
			'username' => 'required|unique:users,username|min:3|varchar:small',
			'email' => 'required|unique:users,email|email|varchar:small',
			'password' => 'required|confirmed|min:6',
            'eula' => 'required'
		);

		$validator = Validator::make($input, $rules);
		return $validator->passes() ? true : $validator->errors();
	}

	public function isValidForLogin() {
		$rules = array(
			'email' => 'required',
			'password' => 'required',
            'rememberMe' => 'boolean'
		);

        $user = User::where('email', Input::get('email'))->firstOrFail();

        if ($user->role_id > UserRole::Member) {
            return Auth::attempt(array('email' => Input::get('email', null), 'password' => Input::get('password', null)), Input::get('rememberMe', false));
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

	public function setPasswordAttribute($value) {
		$this->attributes['password'] = Hash::make($value);
	}

    // Attribute accessors
	public function getDaysUntilSubscriptionExpiresAttribute() {
		return Carbon::now()->diffInDays($this->subscription_expiry);
	}
}
