<?php
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Location;

class LocationsTableSeeder extends Seeder {
    public function run() {
        Location::create(array(
            'name' => 'Omelek Island',
            'location' => 'Kwajalein',
            'state' => 'Marshall Islands',
            'type' => 'Launch Site',
            'status' => 'No longer used'
        ));

        Location::create(array(
            'name' => 'SLC-40',
            'location' => 'Cape Canaveral',
            'state' => 'Florida',
            'type' => 'Launch Site',
            'status' => 'Active'
        ));

        Location::create(array(
            'name' => 'SLC-4E',
            'location' => 'Vandenberg',
            'state' => 'California',
            'type' => 'Launch Site',
            'status' => 'Active'
        ));

        Location::create(array(
            'name' => 'LC-39A',
            'location' => 'Cape Kennedy',
            'state' => 'Florida',
            'type' => 'Launch Site',
            'status' => 'Active'
        ));

        Location::create(array(
            'name' => 'Boca Chica',
            'location' => 'Brownsville',
            'state' => 'Texas',
            'type' => 'Launch Site',
            'status' => 'Planned'
        ));

        Location::create(array(
            'name' => 'Just Read The Instructions (MARMAC 300)',
            'type' => 'ASDS',
            'status' => 'No longer used'
        ));

        Location::create(array(
            'name' => 'LC-1',
            'location' => 'Cape Canaveral',
            'state' => 'Florida',
            'type' => 'Landing Site',
            'status' => 'Planned'
        ));

        Location::create(array(
            'name' => 'SLC-4W',
            'location' => 'Vandenberg',
            'state' => 'California',
            'type' => 'Landing Site',
            'status' => 'Planned'
        ));

        Location::create(array(
            'name' => 'Of Course I Still Love You (MARMAC 304)',
            'type' => 'ASDS',
            'status' => 'Active'
        ));
    }
}