<?php
namespace SpaceXStats\ModelManagers\Objects;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use SpaceXStats\Models\Mission;
use SpaceXStats\Models\Object;
use SpaceXStats\Models\Publisher;
use SpaceXStats\Models\Tag;
use SpaceXStats\Models\Tweeter;

abstract class ObjectCreator {
    protected $object, $input, $errors;

    public function __construct(Object $object) {
        $this->object = $object;
    }

    protected function validate($rules) {
        $validator = Validator::make($this->input, $rules);

        if ($validator->passes()) {
            return true;
        } else {
            $this->errors = $validator->errors();
            return false;
        }
    }

    protected function createMissionRelation() {
        try {
            $mission = Mission::findOrFail(array_get($this->input, 'mission_id', null));
            $this->object->mission()->associate($mission);
        } catch (ModelNotFoundException $e) {
            // Model not found, do not set
        }
    }

    protected function createTagRelations() {
        $tagIds = [];
        foreach ($this->input['tags'] as $tag) {
            $tagId = Tag::firstOrCreate(['name' => $tag['name']])->tag_id;
            array_push($tagIds, $tagId);
        }

        $this->object->tags()->attach($tagIds);
    }

    protected function createPublisherRelation() {
        try {
            $publisher = Publisher::findOrFail(array_get($this->input, 'publisher_id', null));
            $this->object->publisher()->associate($publisher);
        } catch (ModelNotFoundException $e) {
            // Model not found, do not set
        }
    }

    public function getErrors() {
        return $this->errors;
    }

    // https://laracasts.com/series/digging-in/episodes/7#
    abstract public function isValid($input);
    abstract public function create();
}