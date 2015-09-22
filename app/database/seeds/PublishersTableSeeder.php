<?php

class PublishersTableSeeder extends Seeder {
    public function run() {
        Publisher::create(array(
            'name' => 'SpaceX'
        ));
    }
}