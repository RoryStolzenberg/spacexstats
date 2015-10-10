<?php

namespace SpaceXStats\Managers\Objects;

use SpaceXStats\Enums\ObjectPublicationStatus;
use SpaceXStats\Enums\MissionControlType;
use SpaceXStats\Enums\MissionControlSubtype;

class ObjectFromArticle extends ObjectCreator {
    public function isValid($input) {
        $this->input = $input;

        $rules = array_intersect_key($this->object->getRules(), []);
        return $this->validate($rules);
    }

    public function create() {
        \DB::transaction(function() {
            $this->object = \Object::create([
                'user_id'               => \Auth::user()->user_id,
                'type'                  => MissionControlType::Article,
                'title'                 => $this->input['title'],
                'size'                  => strlen($this->input['article']),
                'article'               => $this->input['article'],
                'thumb_filename'        => 'article.png',
                'cryptographic_hash'    => hash('sha256', $this->input['article']),
                'originated_at'         => \Carbon\Carbon::now(),
                'status'                => ObjectPublicationStatus::QueuedStatus
            ]);

            $this->createMissionRelation();
            $this->createTagRelations();

            $this->createPublisherRelation();
        });
    }
}