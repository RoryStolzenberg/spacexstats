<?php
namespace SpaceXStats\Creators\Objects;

use SpaceXStats\Enums\ObjectPublicationStatus;
use SpaceXStats\Enums\MissionControlType;
use SpaceXStats\Enums\MissionControlSubtype;

class ObjectFromFile extends ObjectCreator {

    public function isValid($input) {
        $this->input = $input;

        switch ($input['type']) {
            case MissionControlType::Image:
                $rulesToGet = [];
                break;
            case MissionControlType::GIF:
                $rulesToGet = [];
                break;
            case MissionControlType::Video:
                $rulesToGet = [];
                break;
            case MissionControlType::Audio:
                $rulesToGet = [];
                break;
            case MissionControlType::Document:
                $rulesToGet = [];
                break;
        }

        $rules = array_intersect_key($this->object->getRules(), $rulesToGet);
        return $this->validate($rules);
    }

    public function create() {
        $this->object = \Object::find($this->input['object_id']);

        // Global object
        \DB::transaction(function() {
            $this->object->title = array_get($this->input, 'title', null);
            $this->object->summary = array_get($this->input, 'summary', null);
            $this->object->subtype = array_get($this->input, 'subtype', null);
            $this->object->originated_at = array_get($this->input, 'originated_at', null);
            $this->object->anonymous = array_get($this->input, 'anonymous', false);
            $this->object->attribution = array_get($this->input, 'attribution', null);
            $this->object->author = array_get($this->input, 'author', null);
            $this->object->external_url = array_get($this->input, 'external_url', null);
            $this->object->status = ObjectPublicationStatus::QueuedStatus;

            $this->createMissionRelation();
            $this->createTagRelations();

            $this->object->push();
        });
    }
}