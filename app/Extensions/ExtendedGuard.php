<?php
namespace SpaceXstats\Extensions;

use Illuminate\Support\Facades\Auth;
use SpaceXStats\Library\Enums\UserRole;

class ExtendedGuard extends \Illuminate\Auth\Guard {

    public function isAuthenticated() {
        if (is_null($this->user())) {
            return false;
        }
        return ($this->user()->role_id == UserRole::Unauthenticated);
    }

    public function isMember() {
        if (is_null($this->user())) {
            return false;
        }
        return ($this->user()->role_id >= UserRole::Member);
    }

    public function isSubscriber() {
        if (is_null($this->user())) {
            return false;
        }
        return ($this->user()->role_id >= UserRole::Subscriber);
    }

    public function isCharterSubscriber() {
        if (is_null($this->user())) {
            return false;
        }
        return ($this->user()->role_id >= UserRole::CharterSubscriber);
    }

    public function isAdmin() {
        if (is_null($this->user())) {
            return false;
        }
        return ($this->user()->role_id >= UserRole::Administrator);
    }

    public function isAccessingSelf($user) {
        if (is_null($this->user())) {
            return false;
        }
        return (Auth::id() == $user->user_id);
    }
}