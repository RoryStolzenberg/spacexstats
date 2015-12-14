<?php

namespace SpaceXStats\ModelManagers\Objects;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SpaceXStats\Library\Enums\ObjectPublicationStatus;
use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Library\Enums\MissionControlSubtype;
use SpaceXStats\Models\Object;

class ObjectFromNSFComment extends ObjectCreator {

    public function isValid($input) {
        $this->input = $input;
        return $this->validate($this->object->rules);
    }

    public function create() {
        DB::transaction(function() {

            $this->object = Object::create([
                'user_id'               => Auth::id(),
                'type'                  => MissionControlType::Comment,
                'subtype'               => MissionControlSubtype::NSFComment,
                'title'                 => $this->input['title'],
                'size'                  => strlen($this->input['comment']),
                'summary'               => $this->input['comment'],
                'cryptographic_hash'    => hash('sha256', $this->input['comment']),
                'external_url'          =>$this->input['external_url'],
                'originated_at'         => \Carbon\Carbon::now(),
                'status'                => ObjectPublicationStatus::QueuedStatus
            ]);

            $this->createMissionRelation();
            $this->createTagRelations();

            $this->object->push();
        });

        return $this->object;
    }
}