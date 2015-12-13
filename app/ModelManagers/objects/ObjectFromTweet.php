<?php
namespace SpaceXStats\ModelManagers\Objects;

use Abraham\TwitterOAuth\TwitterOAuth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Library\Enums\ObjectPublicationStatus;
use SpaceXStats\Models\Object;
use SpaceXStats\Models\Tweeter;

class ObjectFromTweet extends ObjectCreator {

    public function isValid($input) {
        $this->input = $input;
        return $this->validate($this->object->rules);
    }

    public function create() {
        DB::transaction(function() {
            $twitterClient = new TwitterOAuth(Config::get('services.twitter.consumerKey'), Config::get('services.twitter.consumerSecret'), Config::get('services.twitter.accessToken'), Config::get('services.twitter.accessSecret'));

            // Fetch the tweet information from Twitter, if a tweet id was passed through (it is possible the tweet was created manually without an id)
            if (array_key_exists('tweet_id', $this->input)) {
                $tweet = $twitterClient->get('statuses/show', ['id' => $this->input['tweet_id']]);
                $tweetOwner = $tweet->user;

                $this->object = Object::create([
                    'user_id'               => Auth::id(),
                    'type'                  => MissionControlType::Tweet,
                    'tweet_text'            => $tweet->text,
                    'tweet_id'              => $tweet->id,
                    'tweet_parent_id'       => $tweet->in_reply_to_status_id,
                    'size'                  => strlen($tweet->text),
                    'title'                 => $tweet->text,
                    'summary'               => $this->input['summary'],
                    'cryptographic_hash'    => hash('sha256', $tweet->text),
                    'originated_at'         => Carbon::createFromFormat('D M d H:i:s P Y', $tweet->created_at)->toDateTimeString(),
                    'status'                => ObjectPublicationStatus::QueuedStatus
                ]);
            } else {

                $this->object = Object::create([
                    'user_id'               => Auth::id(),
                    'type'                  => MissionControlType::Tweet,
                    'tweet_text'            => $this->input['tweet_text'],
                    'size'                  => strlen($this->input['tweet_text']),
                    'title'                 => $this->input['tweet_text'],
                    'summary'               => $this->input['summary'],
                    'cryptographic_hash'    => hash('sha256', $this->input['tweet_text']),
                    'originated_at'         => $this->input['originated_at'],
                    'status'                => ObjectPublicationStatus::QueuedStatus
                ]);
            }

            try {
                if(!isset($tweetOwner)) {
                    $tweetOwner = $twitterClient->get('users/show', ['screen_name' => $this->input['tweet_screen_name']]);
                }

                $tweeter = Tweeter::byScreenName($tweetOwner->screen_name)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                $tweeter = Tweeter::create([
                    'screen_name' => $tweetOwner->screen_name,
                    'user_name' => $tweetOwner->name,
                    'description' => $tweetOwner->description
                ]);

                $tweeter->saveProfilePicture();
            }

            $this->object->tweeter()->associate($tweeter);

            $this->createMissionRelation();
            $this->createTagRelations();

            $this->object->push();
        });

        return $this->object;
    }
}