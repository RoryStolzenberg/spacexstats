<?php

namespace SpaceXStats\Live;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Redis;
use JsonSerializable;

class LiveUpdate implements JsonSerializable, Arrayable {
    private $createdAt, $updatedAt, $timestamp, $update, $updateMd, $updateType, $id;

    /**
     * Constructor for a LiveUpdate object.
     *
     * @param $data
     */
    public function __construct($data) {

        if (is_array($data)) {
            $this->createFromNew($data);
        } else if (is_object($data)) {
            $this->createFromUpdate($data);
        }

        $this->parseTweetsAndImages();
    }

    /**
     * Updates the text of a LiveUpdate, and also sets the updatedAt field and the markdown representation of that update.
     *
     * @param $updateInput
     */
    public function setUpdate($updateInput) {
        $this->updatedAt = Carbon::now();
        $this->update = $updateInput;
        $this->updateMd = \Parsedown::instance()->text($this->update);

        $this->parseTweetsAndImages();
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
            'timestamp' => $this->timestamp
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
            $diffInSeconds = $this->createdAt->diffInSeconds($countdownTo);
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
    private function parseTweetsAndImages() {
        preg_match_all("/http:\/\/i\.imgur\.com\/[a-z1-9]*\.jpg/i", $this->updateMd, $imgurMatches, PREG_OFFSET_CAPTURE);

        foreach($imgurMatches as $imgurMatch) {

        }

        preg_match_all("/(https?:\/\/(?:www\.)?twitter\.com\/[a-z0-9]*\/status\/[0-9]*)/i", $this->updateMd, $twitterMatches, PREG_OFFSET_CAPTURE);

        foreach($twitterMatches as $twitterMatch) {

        }
    }

    /**
     * Creates a LiveUpdate from a new array of data.
     *
     * @internal
     * @param array $data
     */
    private function createFromNew(array $data) {
        // Set the ID
        $this->id = Redis::llen('live:updates');

        // Set the dates and times
        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();

        $this->timestamp = $this->constructTimestamp();

        $this->update       = $data['update'];
        $this->updateMd    = \Parsedown::instance()->text($this->update);

        $this->updateType   = $data['updateType'];
    }

    /**
     * Creates a LiveUpdate from a stored stdClass object of data (creation from a json serialized string)
     *
     * @internal
     * @param \stdClass $data
     */
    private function createFromUpdate(\stdClass $data) {
        $this->id = $data->id;

        $this->createdAt = Carbon::createFromFormat('Y-m-d H:i:s', $data->createdAt);
        $this->updatedAt = Carbon::createFromFormat('Y-m-d H:i:s', $data->updatedAt);

        $this->timestamp = $data->timestamp;

        $this->update = $data->update;
        $this->updateMd = $data->updateMd;

        $this->updateType = $data->updateType;
    }
}