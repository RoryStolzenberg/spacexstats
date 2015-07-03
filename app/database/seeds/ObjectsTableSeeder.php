<?php

use SpaceXStats\Enums\MissionControlType;

class ObjectsTableSeeder extends Seeder {
    public function run() {
        Object::create(array(
            'user_id' => 1,
            'type' => MissionControlType::Image,
            'size' => 1,
            'filetype' => 'jpg',
            'mimetype' => 'image/jpeg',
            'title' => 'DSQU Launch',
            'filename' => 'dsqu.jpg',
            'status' => 'Published',
            'visibility' => 'Hidden'
        ));
    }
}