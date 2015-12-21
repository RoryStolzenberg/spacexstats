<?php

namespace SpaceXStats\Live;

use Abraham\TwitterOAuth\TwitterOAuth;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;
use JsonSerializable;
use SpaceXStats\Services\AcronymService;

class LiveUpdate implements JsonSerializable, Arrayable {
    private $createdAt, $updatedAt, $timestamp, $update, $updateMd, $updateType, $id, $integrations;

    /**
     * Constructor for a LiveUpdate object.
     *
     * @param $data
     */
    public function __construct($data) {

        $data = (array) $data;

        // Set the ID
        $this->id           = isset($data['id']) ? $data['id'] : Redis::llen('live:updates');
        // Set the dates and times
        $this->createdAt    = isset($data['createdAt']) ? Carbon::createFromFormat('Y-m-d H:i:s', $data['createdAt']) : Carbon::now();
        $this->updatedAt    = Carbon::now();
        $this->timestamp    = isset($data['timestamp']) ?  $data['timestamp'] : $this->constructTimestamp();

        $this->setUpdate($data['update']);
        $this->updateType   = $data['updateType'];
    }

    /**
     * Updates the text of a LiveUpdate, and also sets the updatedAt field and the markdown representation of that update.
     *
     * @param $updateInput
     */
    public function setUpdate($updateInput) {
        $this->updatedAt = Carbon::now();
        $this->update = $updateInput;

        $this->parseIntegrations();
        $this->update = (new AcronymService())->parseAndExpand($this->update);

        $this->updateMd = \Parsedown::instance()->text($this->update);
    }

    /**
     * Serialized the LiveUpdate object for storage in a key-value store or when it is json_encoded.
     *
     * @return array
     */
    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'createdAt' => $this->createdAt->toDateTimeString(),
            'updatedAt' => $this->updatedAt->toDateTimeString(),
            'update' => $this->update,
            'updateMd' => $this->updateMd,
            'updateType' => $this->updateType,
            'timestamp' => $this->timestamp,
            'integrations' => $this->integrations
        ];
    }

    /**
     * Converts the LiveUpdate object into an array, for storage into a database, etc.
     *
     * @return array
     */
    public function toArray() {
        return [
            'update' => $this->update,
            'update_type' => $this->updateType,
            'live_event_name' => Redis::get('live:title'),
            'user_id' => Auth::id(),
            'timestamp' => $this->timestamp,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }

    /**
     * Constructs a human readable relative timestamp relative to when the event is being counted down to.
     * If a launch is paused, we will instead show a timestamp which reads "Paused".
     *
     * @internal
     * @return string
     */
    private function constructTimestamp() {
        // Check if paused
        if (!Redis::hget('live:countdown', 'isPaused')) {
            $countdownTo = Carbon::createFromFormat('Y-m-d H:i:s', Redis::hget('live:countdown', 'to'));
            $diffInSeconds = $this->createdAt->diffInSeconds($countdownTo, false);
            $absDiffInSeconds = abs($diffInSeconds);
            $sign = $diffInSeconds < 0 ? '+' : '-';

            if ($absDiffInSeconds > 86400) {
                $days = floor($absDiffInSeconds / 86400);
                $hours = round(($absDiffInSeconds % 86400) / 3600);

                $timestamp = "T{$sign}{$days}d";

                if ($hours !== 0) {
                    $timestamp .= " {$hours}h";
                }
            } elseif ($absDiffInSeconds > 3600) {
                $hours = floor($absDiffInSeconds / 3600);
                $minutes = round(($absDiffInSeconds % 3600) / 60);

                $timestamp = "T{$sign}{$hours}h";

                if ($minutes !== 0) {
                    $timestamp .= " {$minutes}m";
                }
            } elseif ($absDiffInSeconds > 60) {
                $minutes = floor($absDiffInSeconds / 60);
                $seconds = round($absDiffInSeconds % 60);

                $timestamp = "T{$sign}{$minutes}m";

                if ($seconds !== 0) {
                    $timestamp .= " {$seconds}s";
                }
            } else {
                $timestamp = "T{$sign}{$absDiffInSeconds}s";
            }

            return $timestamp;
        }
        return 'Paused';
    }

    /**
     * Takes the markdown representation of the update and parses out any images and tweets it finds, placing them at the
     * end of the nearest paragraph.
     *
     * @internal
     */
    private function parseIntegrations() {
        // Reset the integrations in case we are editing the comment (we don't want more than one)
        $this->integrations = [];

        preg_match_all('/https?:\/\/i\.imgur\.com\/[a-z1-9]*\.(?:jpg|gif|png)/i', $this->update, $imgurMatches);

        foreach($imgurMatches[0] as $imgurMatch) {
            $this->integrations[] = [
                'type'  => 'imgur',
                'url'   => $imgurMatch
            ];
        }

        //preg_match_all('/https?:\/\/(?:www\.)?twitter\.com\/[a-z0-9]*\/status\/([0-9])*/i', $this->update, $twitterMatches);

        /*if (count($twitterMatches) > 0) {
            $twitter = new TwitterOAuth(Config::get('services.twitter.consumerKey'), Config::get('services.twitter.consumerSecret'), Config::get('services.twitter.accessToken'), Config::get('services.twitter.accessSecret'));
            $twitter->setTimeouts(5, 5);
            $tweets = $twitter->get('statuses/lookup', ['id' => $twitterMatches[0]]);

            if ($twitter->getLastHttpCode() == 200) {
                foreach($tweets as $tweet) {
                    $this->integrations[] = [
                        'type' => 'tweet',
                        'author' => $tweet->user->name,
                        'datetime' => $tweet->created_at,
                        'text' => $tweet->text
                    ];
                }
            }
        }*/
    }
}