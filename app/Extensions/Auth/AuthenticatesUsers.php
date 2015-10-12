<?php

namespace SpaceXStats\Extensions\Auth;


trait AuthenticatesUsers
{
    use \Illuminate\Foundation\Auth\AuthenticatesUsers;

    public function logout() {
        return $this->getLogout();
    }
}