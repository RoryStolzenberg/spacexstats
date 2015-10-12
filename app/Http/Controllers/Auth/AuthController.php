<?php

namespace SpaceXStats\Http\Controllers\Auth;

use SpaceXStats\Extensions\Auth\AuthenticatesUsers;
use SpaceXStats\Extensions\Auth\SignsUpUsers;
use SpaceXStats\Extensions\Auth\VerifiesUsers;
use SpaceXStats\Library\Enums\UserRole;
use SpaceXStats\Mail\Mailers\UserMailer;
use SpaceXStats\Models\Profile;
use SpaceXStats\Models\User;
use Validator;
use SpaceXStats\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;


/**
 * Class AuthController
 *
 * Some modifications have been made to the default Laravel AuthController. This class normally extends
 * Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers, but I have a need to override some of the
 * default methods included in both the AuthenticatesUsers & RegistersUsers traits, so I have extended these
 * traits at SpaceXStats\Extensions\Auth\AuthenticatesUsers & SpaceXStats\Extensions\Auth\SignsUpUsers, which replaces
 * the former traits, respectively.
 *
 * @package SpaceXStats\Http\Controllers\Auth
 */
class AuthController extends Controller
{
    use ThrottlesLogins, AuthenticatesUsers;

    use VerifiesUsers {
        AuthenticatesUsers::redirectPath insteadof VerifiesUsers;
    }

    use SignsUpUsers {
        AuthenticatesUsers::redirectPath insteadof SignsUpUsers;
    }

    protected $redirectPath = '/user';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'getLogout']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|varchar:small',
            'email' => 'required|email|varchar:small|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration, also send them a welcome email.
     *
     * @param UserMailer $mailer
     * @param  array $data
     * @return User
     */
    protected function create(UserMailer $mailer, array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'], // Hashed as a mutator on the User model
            'key' => str_random(32),
            'role_id' => UserRole::Unauthenticated
        ]);

        // Associate a profile
        $profile = new Profile();
        $profile->user()->associate($user)->save();

        // Send a welcome email
        $mailer->welcome($user);

        return $user;
    }

    /*public function create() {
            return Redirect::home()->with('flashMessage', $this->flashMessages['accountCreated']);
            return Redirect::back()->withErrors($isValidForSignUp)->withInput(Input::except(['password', 'password_confirmation']))
                ->with('flashMessage', $this->flashMessages['accountCouldNotBeCreatedValidationError']);

    }*/

    public function verify($email, $key) {
        if ($this->user->isValidKey($email, $key)) {
            return Redirect::route('users.login')
                ->with('flashMessage', $this->flashMessages['accountActivated']);
        } else {
            return Redirect::route('home')
                ->with('flashMessage', $this->flashMessages['accountCouldNotBeActivated']);
        }
    }

    /*public function login() {
        (Request::isMethod('post')) {

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
    }*/
}
