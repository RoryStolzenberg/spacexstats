<?php
namespace SpaceXStats\Creators\Objects;

abstract class ObjectCreator {
    protected $object, $errors;

    protected function createMissionRelation($input) {
        try {
            $mission = Mission::findOrFail(array_get($input, 'mission_id', null))->get();
            $this->object->mission()->associate($mission);

        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Model not found, do not set
        }
    }

    protected function createTagRelations($input) {
        $tagIds = [];
        foreach ($input['tags'] as $tag) {
            $tagId = Tag::firstOrCreate(array('name' => $tag['name']))->tag_id;
            array_push($tagIds, $tagId);
        }

        $this->object->tags()->attach($tagIds);
    }

    protected function getErrors() {
        return $this->errors();
    }
}