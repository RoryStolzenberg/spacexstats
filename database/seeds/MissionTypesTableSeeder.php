<?php
use Illuminate\Database\Seeder;
use SpaceXStats\Models\MissionType;

class MissionTypesTableSeeder extends Seeder {
    public function run() {

        // Any changes made here must also be reflected in SpaceXStats/Library/Enums/MissionType
        MissionType::insert(array(
            array('name' => 'Dragon (ISS)'),
            array('name' => 'Dragon (Freeflight)'),
            array('name' => 'Communications Satellite'),
            array('name' => 'Constellation Mission'),
            array('name' => 'SpaceX Constellation Mission'),
            array('name' => 'Experimental'),
            array('name' => 'Demo Flight'),
            array('name' => 'Military'),
            array('name' => 'Scientific')
        ));
    }
}