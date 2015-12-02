<?php
namespace SpaceXStats\ModelManagers\Objects;

use SpaceXStats\Library\Enums\Status;
use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Library\Enums\MissionControlSubtype;

class ObjectFromTweet extends ObjectCreator {

    public function isValid($input) {

    }

    public function create() {
        return $this->object;
    }
}