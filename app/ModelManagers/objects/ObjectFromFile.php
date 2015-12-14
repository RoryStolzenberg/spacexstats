<?php
namespace SpaceXStats\ModelManagers\Objects;

use Illuminate\Support\Facades\DB;
use SpaceXStats\Library\Enums\ObjectPublicationStatus;
use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Models\Object;

class ObjectFromFile extends ObjectCreator {

    public function isValid($input) {
        $this->input = $input;
        return $this->validate($this->object->rules);
    }

    public function create() {
        $this->object = Object::find($this->input['object_id']);

        // Global object
        DB::transaction(function() {
            $this->object->title = array_get($this->input, 'title', null);
            $this->object->summary = array_get($this->input, 'summary', null);
            $this->object->subtype = array_get($this->input, 'subtype', null);
            $this->object->originated_at = array_get($this->input, 'originated_at', null);
            $this->object->anonymous = array_get($this->input, 'anonymous', false);
            $this->object->attribution = array_get($this->input, 'attribution', null);
            $this->object->author = array_get($this->input, 'author', null);
            $this->object->external_url = array_get($this->input, 'external_url', null);
            $this->object->originated_at = array_get($this->input, 'originated_at', null);

            $this->object->status = ObjectPublicationStatus::QueuedStatus;

            $this->createMissionRelation();
            $this->createTagRelations();

            $this->object->push();
        });

        return $this->object;
    }
}