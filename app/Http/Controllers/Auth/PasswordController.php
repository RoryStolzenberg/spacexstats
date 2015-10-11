<?php

namespace SpaceXStats\Http\Controllers\Auth;

use SpaceXStats\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function forgotPassword() {
        if (Request::isMethod('get')) {
            return view('users.forgotpassword');

        } else if (Request::isMethod('post')) {
            // Process forgot password
        }
    }

    public function resetPassword() {
        if (Request::isMethod('get')) {
            return view('users.resetpassword');

        } else if (Request::isMethod('post')) {
            // Process forgot password
        }
    }
}
