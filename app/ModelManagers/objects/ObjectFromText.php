<?php
namespace SpaceXStats\Managers\Objects;

use Illuminate\Support\Facades\DB;
use SpaceXStats\Library\Enums\ObjectPublicationStatus;
use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Library\Enums\MissionControlSubtype;
use SpaceXStats\Models\Object;

class ObjectFromText extends ObjectCreator {

    public function isValid($input) {
        $this->input = $input;

        $rules = array_intersect_key($this->object->getRules(), []);
        return $this->validate($rules);
    }

    public function create() {
        DB::transaction(function() {

            $this->object = Object::create([
                'user_id'               => Auth::id(),
                'type'                  => MissionControlType::Text,
                'title'                 => $this->input['title'],
                'size'                  => strlen($this->input['content']),
                'summary'               => $this->input['content'],
                'anonymous'             => array_get($this->input, 'anonymous', false),
                'cryptographic_hash'    => hash('sha256', $this->input['content']),
                'originated_at'         => \Carbon\Carbon::now(),
                'status'                => ObjectPublicationStatus::QueuedStatus
            ]);

            $this->createMissionRelation();
            $this->createTagRelations();

            $this->object->push();
        });
    }
}