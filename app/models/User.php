<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Carbon\Carbon;

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
	public function role() {
		return $this->belongsTo('Role');
	}

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

	// Helpers
	public function isValidForSignUp($input) {
		$rules = array(
			'username' => 'required|unique:users,username|min:3|max:20',
			'email' => 'required|email|max:50',
			'password' => 'required|confirmed|min:6'
		);

		$validator = Validator::make($input, $rules);
		return $validator->passes() ? true : $validator->errors();
	}

	public function isValidForLogin($input) {
		$rules = array(
			'email' => 'required',
			'password' => 'required'
		);	

		return Auth::attempt($input);
	}

	public function isValidKey($email, $key) {
		$user = User::where('email', urldecode($email))->where('key', $key)->first();
		if (!empty($user)) {
			$user->role_id = UserRole::Member;
			return $user->save();			
		} else {
			return false;
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
