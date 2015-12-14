<?php
namespace SpaceXStats\ModelManagers\Objects;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SpaceXStats\Library\Enums\ObjectPublicationStatus;
use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Models\Object;

class ObjectFromText extends ObjectCreator {

    public function isValid($input) {
        $this->input = $input;
        return $this->validate($this->object->rules);
    }

    public function create() {
        DB::transaction(function() {

            $this->object = Object::create([
                'user_id'               => Auth::id(),
                'type'                  => MissionControlType::Text,
                'title'                 => $this->input['title'],
                'size'                  => strlen($this->input['summary']),
                'summary'               => $this->input['summary'],
                'anonymous'             => array_get($this->input, 'anonymous', false),
                'cryptographic_hash'    => hash('sha256', $this->input['summary']),
                'originated_at'         => Carbon::now(),
                'original_content'      => true,
                'status'                => ObjectPublicationStatus::QueuedStatus
            ]);

            $this->createMissionRelation();
            $this->createTagRelations();

            $this->object->push();
        });

        return $this->object;
    }
}