<?php
namespace SpaceXStats\Extensions\Auth;

use Illuminate\Foundation\Auth\RedirectsUsers;

/**
 * Class SignsUpUsers
 *
 * This trait is a replacement for a the \Illuminate\Foundation\Auth\RegistersUsers trait. Reasons for replacement:
 * My preferred naming solution for registration is "sign up" rather than "register". No other changes are present.
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
    public function getRegister()
    {
        return view('auth.signup');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        Auth::login($this->create($request->all()));

        return redirect($this->redirectPath());
    }

}