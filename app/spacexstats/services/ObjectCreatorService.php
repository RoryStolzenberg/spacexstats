<?php
namespace SpaceXStats\Services;

use SpaceXStats\Enums\MissionControlType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Object;
use \Tag;
use \Mission;

class ObjectCreatorService implements CreatorServiceInterface {
    protected $object, $tagCreator, $errors;

    public function __construct(\Object $object) {
        $this->object = $object;
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
        Object::create($input);
    }

    public function createFromFileSubmission($input) {
        $this->object = Object::find($input['object_id']);

        // Global object
        \DB::transaction(function() use($input) {
            $this->object->title = array_get($input, 'title', null);
            $this->object->summary = array_get($input, 'summary', null);
            $this->object->subtype = array_get($input, 'subtype', null);
            $this->object->originated_at = array_get($input, 'originated_at', null);
            $this->object->anonymous = array_get($input, 'anonymous', false);
            $this->object->attribution = array_get($input, 'attribution', null);
            $this->object->author = array_get($input, 'author', null);
            $this->object->status = 'Queued';

            // Set the mission relation if it exists
            $this->createMissionRelation($input);

            // Set the tag relations
            $this->createTagRelations($input);

            $this->object->save();
        });
    }

    public function createFromWrittenSubmission($input) {
        $this->object = new Object();

        \DB::transaction(function() use($input) {
            $this->object->type = MissionControlType::Post;
            $this->object->title = array_get($input, 'title', null);
            $this->object->summary = array_get($input, 'contents', null);
            $this->object->anonymous = array_get($input, 'anonymous', false);
            $this->object->originated_at = \Carbon\Carbon::now();
            $this->object->status = 'Queued';

            // Set the mission relation if it exists
            $this->createMissionRelation($input);

            // Set the tag relations
            $this->createTagRelations($input);

            $this->object->save();
        });
    }

    private function createMissionRelation($input) {
        try {
            $mission = Mission::findOrFail(array_get($input, 'mission_id', null))->get();
            $this->object->mission()->associate($mission);

        } catch (ModelNotFoundException $e) {
            // Model not found, do not set
        }
    }

    private function createTagRelations($input) {
        $tagIds = [];
        foreach ($input['tags'] as $tag) {
            $tagId = Tag::firstOrCreate(array('name' => $tag['name']))->tag_id;
            array_push($tagIds, $tagId);
        }

        $this->object->tags()->attach($tagIds);
    }

    public function getErrors() {
        return $this->errors;
    }
}