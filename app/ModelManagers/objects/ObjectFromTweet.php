<?php
namespace SpaceXStats\ModelManagers\Objects;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ObjectFromTweet extends ObjectCreator {

    public function isValid($input) {

    }

    public function create() {
        // Fetch the tweet information from Twitter, if a tweet id was passed through (it is possible the tweet was created manually without an id)
        if (!is_null($this->input['tweet_id'])) {

            $twitter = new TwitterOAuth(Config::get('services.twitter.consumerKey'), Config::get('services.twitter.consumerSecret'), Config::get('services.twitter.accessToken'), Config::get('services.twitter.accessSecret'));
            $tweet = $twitter->get('statuses/show', ['id' => $this->input['tweet_id']]);

            DB::transaction(function() use($tweet) {
                $this->object = Object::create([
                    'user_id'               => Auth::id(),
                    'type'                  => MissionControlType::Tweet,
                    'title'                 => $this->input['title'],
                    'size'                  => strlen($this->input['article']),
                    'article'               => $this->input['article'],
                    'cryptographic_hash'    => hash('sha256', $this->input['article']),
                    'originated_at'         => Carbon::now(),
                    'status'                => ObjectPublicationStatus::QueuedStatus
                ]);

                $this->createMissionRelation();
                $this->createTagRelations();
                $this->createTweeterRelation();
            });

        } else {
            DB::transaction(function() {
                $this->object = Object::create([

                ]);

                $this->createMissionRelation();
                $this->createTagRelations();
                $this->createTweeterRelation();
            });
        }
    }
}