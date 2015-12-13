<?php

namespace SpaceXStats\ModelManagers\Objects;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SpaceXStats\Library\Enums\ObjectPublicationStatus;
use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Library\Enums\MissionControlSubtype;
use SpaceXStats\Models\Object;

class ObjectFromRedditComment extends ObjectCreator {

    public function isValid($input) {
        $this->input = $input;
        return $this->validate($this->object->rules);
    }

    public function create() {
        DB::transaction(function() {

            $this->object = Object::create([
                'user_id'               => Auth::id(),
                'type'                  => MissionControlType::Comment,
                'subtype'               => MissionControlSubtype::RedditComment,
                'title'                 => $this->input['title'],
                'size'                  => strlen($this->input['summary']),
                'summary'               => $this->input['summary'],
                'cryptographic_hash'    => hash('sha256', $this->input['summary']),
                'external_url'          => $this->input['external_url'],
                'reddit_comment_id'     => $this->input['reddit_comment_id'],
                'reddit_parent_id'      => $this->input['reddit_parent_id'],
                'reddit_subreddit'      => $this->input['reddit_subreddit'],
                'originated_at'         => $this->input['originated_at'],
                'status'                => ObjectPublicationStatus::QueuedStatus
            ]);

            $this->createMissionRelation();
            $this->createTagRelations();

            $this->object->push();
        });

        return $this->object;
    }
}