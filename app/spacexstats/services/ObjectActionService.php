<?php
namespace SpaceXStats\Services;

use SpaceXStats\Enums\MissionControlType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Object;
use \Tag;
use \Mission;

class ObjectActionService implements ActionServiceInterface {
    protected $object, $tagActioner, $errors;

    public function __construct(\Object $object, TagActionService $tagActioner) {
        $this->object = $object;
        $this->tagActioner = $tagActioner;
    }

    public function isValid($input) {
        $objectValidation = $this->object->isValidForSubmission($input);

        if ($objectValidation === true) {
            return true;
        } else {
            $this->errors = $objectValidation;
            return false;
        }
    }

    public function create($input) {
        $this->object = Object::find($input['object_id']);

        // Global object properties
        $this->object->title = $input['title'];
        $this->object->summary = $input['summary'];
        $this->object->subtype = $input['subtype'];

        // Set the mission relation if it exists
        $this->createMissionRelation($input);

        // Set the tag relations
        $this->createTagRelations($input);

        if ($input['type'] == MissionControlType::Image) {
            $this->object->attribution = $input['attribution'];
            $this->object->anonymous = $input['anonymous'];
            $this->object->author = $input['author'];
        }

        $this->object->save();
    }

    private function createMissionRelation($input) {
        try {
            $mission = Mission::findOrFail($input['mission_id']);
            $this->object->mission()->associate($mission);

        } catch (ModelNotFoundException $e) {
            // Model not found, do not set
        }
    }

    private function createTagRelations($input) {
        $tagIds = [];
        foreach ($input['tags'] as $tag) {
            try {
                $tagId = Tag::where('name', $tag['name'])->first(['tag_id'])->tag_id;
            } catch (ModelNotFoundException $e) {
                $tagId = Tag::create(array('name' => $tag['name']))->tag_id;
            }
            array_push($tagIds, $tagId);
        }

        $this->object->tags()->attach($tagIds);
    }

    public function getErrors() {
        return $this->errors;
    }
}