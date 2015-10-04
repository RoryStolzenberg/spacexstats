<?php

use SpaceXStats\Enums\MissionControlType;
use SpaceXStats\Enums\MissionControlSubtype;

class ObjectsTableSeeder extends Seeder {
    public function run() {
        Object::create(array(
            'user_id' => 1,
            'mission_id' => 2,
            'type' => MissionControlType::Image,
            'size' => 8000,
            'filetype' => 'jpg',
            'mimetype' => 'image/jpeg',
            'title' => 'DSQU Launch',
            'filename' => 'dsqu.jpg',
            'status' => 'Published',
            'actioned_at' => \Carbon\Carbon::now(),
            'visibility' => 'Default'
        ));

        Object::create(array(
            'user_id' => 1,
            'mission_id' => 1,
            'type' => MissionControlType::Image,
            'subtype' => MissionControlSubtype::MissionPatch,
            'size' => 2000,
            'filetype' => 'jpg',
            'mimetype' => 'image/jpeg',
            'title' => 'F1F1 mission patch',
            'filename' => 'f1f1.jpg',
            'status' => 'Published',
            'actioned_at' => \Carbon\Carbon::now(),
            'visibility' => 'Default'
        ));
    }
}