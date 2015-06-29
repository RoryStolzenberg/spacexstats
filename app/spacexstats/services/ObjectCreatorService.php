<?php
namespace SpaceXStats\Services;

use SpaceXStats\Enums\MissionControlType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Object;
use \Mission;

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
        $object = Object::find($input['object_id']);

        // Global object properties
        $object->title = $input['title'];
        $object->summary = $input['summary'];

        // Set the mission relation if it exists
        try {
            $mission = Mission::findOrFail($input['mission_id']);
            $object->mission()->associate($mission);

        } catch (ModelNotFoundException $e) {
            // Model not found, do not set
        }

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