<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Payload;

class PayloadsTableSeeder extends Seeder {
    public function run() {
        Payload::create([
            'mission_id' => 1,
            'name' => 'FalconSAT-2',
            'operator' => "U.S. Air Force",
            'primary' => true,
            'mass' => 19.5,
            'link' => 'http://space.skyrocket.de/doc_sdat/falconsat-2.htm'
        ]);

        Payload::create([
            'mission_id' => 3,
            'name' => 'Trailblazer',
            'operator' => "U.S. Air Force",
            'primary' => false,
            'mass' => 83.5,
            'link' => 'http://space.skyrocket.de/doc_sdat/trailblazer.htm'
        ]);

        Payload::create([
            'mission_id' => 3,
            'name' => 'PRESat',
            'operator' => "NASA Ames Research Center",
            'primary' => false,
            'mass' => 4,
            'link' => 'http://space.skyrocket.de/doc_sdat/presat.htm'
        ]);

        Payload::create([
            'mission_id' => 3,
            'name' => 'NanoSail-D',
            'operator' => "NASA Ames Research Center",
            'primary' => false,
            'mass' => 4,
            'link' => 'http://space.skyrocket.de/doc_sdat/nanosail-d.htm'
        ]);

        Payload::create([
            'mission_id' => 3,
            'name' => 'Celestis 7',
            'operator' => "Celestis",
            'primary' => false,
            'link' => 'http://space.skyrocket.de/doc_sdat/celestis-07.htm'
        ]);

        Payload::create([
            'mission_id' => 5,
            'name' => 'RazakSAT',
            'operator' => "Astronautic Technology, Malaysia",
            'primary' => true,
            'mass' => 200,
            'link' => 'http://space.skyrocket.de/doc_sdat/razaksat.htm'
        ]);
    }
}