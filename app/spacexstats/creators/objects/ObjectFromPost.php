<?php
namespace SpaceXStats\Creators\Objects;

use SpaceXStats\Creators\Creatable;

class ObjectFromPost extends ObjectCreator implements Creatable {

    public function isValid($input) {
        $this->input = $input;

        $rules = array_intersect_key($this->object->getRules(), []);
        return $this->validate($rules);
    }

    public function create() {
        \DB::transaction(function() {
           $this->object->save();
        });
    }
}