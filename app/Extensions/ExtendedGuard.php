<?php
namespace SpaceXstats\Extensions;

use Illuminate\Support\Facades\Auth;
use SpaceXStats\Library\Enums\UserRole;

class ExtendedGuard extends \Illuminate\Auth\Guard {

    public function isAuthenticated() {
        $this->nullCheck();
        return ($this->user()->role_id == UserRole::Unauthenticated);
    }

    public function isMember() {
        $this->nullCheck();
        return ($this->user()->role_id >= UserRole::Member);
    }

    public function isSubscriber() {
        $this->nullCheck();
        return ($this->user()->role_id >= UserRole::Subscriber);
    }

    public function isCharterSubscriber() {
        $this->nullCheck();
        return ($this->user()->role_id >= UserRole::CharterSubscriber);
    }

    public function isAdmin() {
        $this->nullCheck();
        return ($this->user()->role_id >= UserRole::Administrator);
    }

    public function isAccessingSelf($user) {
        $this->nullCheck();
        return (Auth::id() == $user->user_id);
    }

    private function nullCheck() {
        if (is_null($this->user())) {
            return false;
        }
    }
}