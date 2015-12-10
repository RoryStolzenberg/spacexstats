<?php
namespace SpaceXStats\ModelManagers\Objects;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ObjectFromTweet extends ObjectCreator {

    public function isValid($input) {

    }

    public function create() {
        // Fetch the tweet information from Twitter
        $twitter = new TwitterOAuth(Config::get('services.twitter.consumerKey'), Config::get('services.twitter.consumerSecret'), Config::get('services.twitter.accessToken'), Config::get('services.twitter.accessSecret'));
        $tweet = $twitter->get('statuses/show', ['id' => $this->input['tweet_id']]);

        DB::transaction(function() {
            $this->object = Object::create([

            ]);

            $this->createMissionRelation();
            $this->createTagRelations();
            $this->createTweeterRelation();
        });
    }
}