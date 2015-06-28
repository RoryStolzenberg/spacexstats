<?php
namespace SpaceXStats\Services;

use SpaceXStats\Enums\MissionControlType;

class ObjectCreatorService implements CreatorServiceInterface {
    protected $object, $errors;

    public function __construct(\Object $object) {
        $this->object = $object;
    }

    public function isValid($input) {
        $objectValidation = $this->object->isValidForSubmission($input);

        if ($objectValidation) {
            return true;
        } else {
            $this->errors = $objectValidation;
            return false;
        }
    }

    public function make($input) {
        $object = \Object::find($input['object_id']);

        // Global object properties
        $object->title = $input['title'];
        $object->summary = $input['summary'];
        $object->mission()->associate(\Mission::find($input['mission_id']));
        $object->status = 'Queued';

        if ($input['type'] == MissionControlType::Image) {
            $object->attribution = $input['attribution'];
            $object->author = $input['author'];


        }

        $object->save();
    }

    public function getErrors() {
        return $this->errors;
    }
}