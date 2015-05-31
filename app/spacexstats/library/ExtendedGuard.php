<?php
use SpaceXStats\Enums\UserRole;

class ExtendedGuard extends \Illuminate\Auth\Guard {
    public function isAuthenticated() {
        if (is_null($this->user())) {
            return false;
        } else {
            return ($this->user()->role_id >= UserRole::Unauthenticated);
        }
    }

    public function isMember() {
        if (is_null($this->user())) {
            return false;
        } else {
            return ($this->user()->role_id >= UserRole::Member);
        }
    }

    public function isSubscriber() {
        if (is_null($this->user())) {
            return false;
        } else {
            return ($this->user()->role_id >= UserRole::Subscriber);
        }
    }

    public function isAdmin() {
        if (is_null($this->user())) {
            return false;
        } else {
            return ($this->user()->role_id >= UserRole::Administrator);
        }
    }

    public function isAccessingSelf(User $user) {
        if (is_null($this->user())) {
            return false;
        } else {
            return (Auth::user()->user_id == $user->user_id);
        }
    }
}