<?php
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Destination;

class DestinationsTableSeeder extends Seeder {
    public function run() {
        Destination::create(array('destination' => 'Low Earth Orbit'));
        Destination::create(array('destination' => 'Low Earth Orbit (ISS)'));
        Destination::create(array('destination' => 'Polar Orbit'));
        Destination::create(array('destination' => 'Medium Earth Orbit'));
        Destination::create(array('destination' => 'Geostationary Transfer Orbit'));
        Destination::create(array('destination' => 'Supersynchronous GTO'));
        Destination::create(array('destination' => 'High Earth Orbit'));
    }
}