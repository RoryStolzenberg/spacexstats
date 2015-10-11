<?php
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Vehicle;

class VehiclesTableSeeder extends Seeder {
    public function run() {
        Vehicle::create(array(
            'vehicle' => 'Falcon 1'
        ));

        Vehicle::create(array(
            'vehicle' => 'Falcon 9 v1.0'
        ));

        Vehicle::create(array(
            'vehicle' => 'Falcon 9 v1.1'
        ));

        Vehicle::create(array(
            'vehicle' => 'Falcon 9 v1.2'
        ));

        Vehicle::create(array(
            'vehicle' => 'Falcon Heavy'
        ));


    }
}