<?php
namespace SpaceXStats\Extensions\Auth;

use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class SignsUpUsers
 *
 * This trait is a replacement for a the \Illuminate\Foundation\Auth\RegistersUsers trait. Reasons for replacement:
 * My preferred naming solution for registration is "sign up" rather than "register".
 * Signing up is handled via AJAX rather than simple HTTP requests.
 *
 * @package SpaceXStats\Extensions\Auth
 */
trait SignsUpUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSignUp()
    {
        return view('auth.signup');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postSignUp(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = $this->create($request->all());

        return response()->json($user);
    }
}