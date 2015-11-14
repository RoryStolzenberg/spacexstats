<?php

namespace SpaceXStats\Live;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Redis;
use JsonSerializable;

class LiveUpdate implements JsonSerializable, Arrayable {
    private $createdAt, $updatedAt, $timestamp, $update, $updateType, $id;

    public function __construct(array $data) {
        // Set the dates and times
        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();

        $this->timestamp = $this->constructTimestamp();

        $this->update       = $data['update'];
        $this->updateMd    = \Parsedown::instance()->text($this->update);

        $this->updateType   = $data['updateType'];
        $this->id           = $data['id'];

        //$this->parseTweetsAndImages();
    }

    public function setUpdate($updateInput) {
        $this->updatedAt = Carbon::now();
        $this->update = $updateInput;
    }

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

    public function toArray() {
        return [
            'update' => $this->update,
            'update_type' => $this->updateType
        ];
    }

    private function constructTimestamp() {
        // Setup
        $countdownTo = Carbon::createFromFormat('Y-m-d H:i:s', Redis::get('live:countdownTo'));
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

    private function parseTweetsAndImages() {
        preg_match_all("/http:\/\/i\.imgur\.com\/[a-z1-9]*\.jpg/i", $this->updateMd, $imgurMatches, PREG_OFFSET_CAPTURE);

        foreach($imgurMatches as $imgurMatch) {

        }

        preg_match_all("/(https?:\/\/(?:www\.)?twitter\.com\/[a-z0-9]*\/status\/[0-9]*)/i", $this->updateMd, $twitterMatches, PREG_OFFSET_CAPTURE);

        foreach($twitterMatches as $twitterMatch) {

        }
    }
}