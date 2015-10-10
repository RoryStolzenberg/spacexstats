<?php

namespace SpaceXStats\Managers\Objects;

use SpaceXStats\Enums\ObjectPublicationStatus;
use SpaceXStats\Enums\MissionControlType;
use SpaceXStats\Enums\MissionControlSubtype;

class ObjectFromRedditComment extends ObjectCreator {

    public function isValid($input) {
        $this->input = $input;

        $rules = array_intersect_key($this->object->getRules(), []);
        return $this->validate($rules);
    }

    public function create() {
        \DB::transaction(function() {

            $this->object = \Object::create([
                'user_id'               => \Auth::user()->user_id,
                'type'                  => MissionControlType::Comment,
                'subtype'               => MissionControlSubtype::RedditComment,
                'title'                 => $this->input['title'],
                'size'                  => strlen($this->input['summary']),
                'summary'               => $this->input['summary'],
                'thumb_filename'        => 'comment.png',
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
    }
}