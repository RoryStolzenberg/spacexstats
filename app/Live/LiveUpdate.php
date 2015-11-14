<?php

namespace SpaceXStats\Live;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class LiveUpdate implements JsonSerializable, Arrayable {
    private $createdAt, $updatedAt, $update, $updateType, $id;

    public function __construct(array $data) {
        // Set the dates and times
        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();

        $this->update       = $data['update'];
        $this->updateType   = $data['updateType'];
        $this->id           = $data['id'];

        $this->parseTweetsAndImages();
    }

    public function setUpdate($updateInput) {
        $this->updatedAt = Carbon::now();
        $this->update = $updateInput;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'update' => $this->update,
            'updateType' => $this->updateType
        ];
    }

    public function toArray() {
        return [
            'update' => $this->update,
            'update_type' => $this->updateType
        ];
    }

    private function parseTweetsAndImages() {

    }
}