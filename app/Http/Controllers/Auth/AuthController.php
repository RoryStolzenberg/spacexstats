<?php

namespace SpaceXStats\Http\Controllers\Auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use SpaceXStats\Extensions\Auth\AuthenticatesUsers;
use SpaceXStats\Extensions\Auth\SignsUpUsers;
use SpaceXStats\Extensions\Auth\VerifiesUsers;
use SpaceXStats\Library\Enums\UserRole;
use SpaceXStats\Mail\Mailers\UserMailer;
use SpaceXStats\Models\Profile;
use SpaceXStats\Models\User;
use Illuminate\Support\Facades\Validator;
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
     * @param UserMailer $mailer
     */
    public function __construct(UserMailer $mailer)
    {
        $this->mailer = $mailer;
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
            'username' => 'required|varchar:small|min:4',
            'email' => 'required|email|varchar:small|unique:users',
            'password' => 'required|min:6',
            'eula' => 'required|accepted'
        ]);
    }

    /**
     * Create a new user instance after a valid registration, also send them a welcome email.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = new User();
        $user->username     = $data['username'];
        $user->email        = $data['email'];
        $user->password     = $data['password']; // Hashed as a mutator on the User model
        $user->key          = str_random(32);
        $user->role_id      = UserRole::Unauthenticated;

        DB::transaction(function() use($user) {
            $user->save();

            // Associate a profile
            $profile = new Profile();
            $profile->user()->associate($user)->save();
        });

        // Add a welcome email to the queue
        $this->mailer->welcome($user);

        return $user;
    }

    public function verify(User $user, $userId, $key) {
        if ($user->isValidKey($userId, $key)) {
            return redirect('/auth/login')->with('flashMessage', Lang::get('auth.accountActivated'));
        } else {
            return redirect('/')->with('flashMessage', Lang::get('auth.accountCouldNotBeActivated'));
        }
    }

    public function authenticated(Request $request, $user) {
        return redirect("/users/{$user->username}");
    }

    /**
     * Endpoint to check if the username exists asynchronously from the signup form.
     *
     * @param $usernameChallenge
     * @return \Illuminate\Http\JsonResponse
     */
    public function isUsernameTaken($usernameChallenge) {
        try {
            User::byUsername($usernameChallenge);
        } catch (ModelNotFoundException $e) {
            return response()->json([ 'taken' => false ]);
        }
        return response()->json([ 'taken' => true ]);
    }
}
