<?php
namespace SpaceXStats\Presenters;

use Illuminate\Support\Facades\Auth;
use SpaceXStats\Library\Enums\UserRole;

class UserPresenter {

    protected $entity;

    function __construct($entity) {
        $this->entity = $entity;
    }

    public function role_id() {
        return UserRole::getKey($this->entity->role_id);
    }
}