<?php
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Publisher;

class PublishersTableSeeder extends Seeder {
    public function run() {
        Publisher::create(array(
            'name' => 'SpaceX',
            'url' => 'http://spacex.com'
        ));

        Publisher::create(array(
            'name' => 'The New York Times',
            'url' => 'http://nyt.com'
        ));
    }
}