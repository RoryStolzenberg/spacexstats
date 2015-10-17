<?php

namespace SpaceXStats\Managers\Objects;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SpaceXStats\Library\Enums\ObjectPublicationStatus;
use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Library\Enums\MissionControlSubtype;
use SpaceXStats\Models\Object;

class ObjectFromPressRelease extends ObjectCreator {
    public function isValid($input) {
        $this->input = $input;

        $rules = array_intersect_key($this->object->getRules(), []);
        return $this->validate($rules);
    }

    public function create() {
        DB::transaction(function() {
            $this->object = Object::create([
                'user_id'               => Auth::id(),
                'type'                  => MissionControlType::Article,
                'subtype'               => MissionControlSubtype::PressRelease,
                'title'                 => $this->input['title'],
                'size'                  => strlen($this->input['article']),
                'article'               => $this->input['article'],
                'cryptographic_hash'    => hash('sha256', $this->input['article']),
                'originated_at'         => \Carbon\Carbon::now(),
                'publisher_id'          => Publisher::where('name', 'SpaceX')->first()->publisher_id,
                'status'                => ObjectPublicationStatus::QueuedStatus
            ]);

            $this->createMissionRelation();
            $this->createTagRelations();

            $this->createPublisherRelation();
        });
    }
}