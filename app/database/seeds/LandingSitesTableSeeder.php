<?php

class LandingSitesTableSeeder extends Seeder {
    public function run() {
        LandingSite::create(array(
            'name' => 'Just Read The Instructions'
        ));

        LandingSite::create(array(
            'name' => 'LC-1',
            'location' => 'Cape Canaveral',
            'state' => 'Florida'
        ));

        LandingSite::create(array(
            'name' => 'SLC-4W',
            'location' => 'Vandenberg',
            'state' => 'California'
        ));

        LandingSite::create(array(
            'name' => 'Of Course I Still Love You'
        ));
    }
}