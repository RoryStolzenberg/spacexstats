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

        Payload::create([
            'mission_id' => 7,
            'name' => 'SMDC-ONE 1',
            'operator' => "U.S. Army SMDC",
            'primary' => false,
            'mass' => 4,
            'link' => 'http://space.skyrocket.de/doc_sdat/smdc-one.htm'
        ]);

        Payload::create([
            'mission_id' => 7,
            'name' => 'QbX 1',
            'operator' => "NRL Naval Center for Space for NRO",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/qbx-1.htm'
        ]);

        Payload::create([
            'mission_id' => 7,
            'name' => 'QbX 2',
            'operator' => "NRL Naval Center for Space for NRO",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/qbx-1.htm'
        ]);

        Payload::create([
            'mission_id' => 7,
            'name' => 'Mayflower-Caerus',
            'operator' => "Northrop Grumman, University of Southern California",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/mayflower-caerus.htm'
        ]);

        Payload::create([
            'mission_id' => 7,
            'name' => 'Perseus 000',
            'operator' => "Los Alamos National Laboratory",
            'primary' => false,
            'mass' => 1.5,
            'link' => 'http://space.skyrocket.de/doc_sdat/perseus-000.htm'
        ]);

        Payload::create([
            'mission_id' => 7,
            'name' => 'Perseus 001',
            'operator' => "Los Alamos National Laboratory",
            'primary' => false,
            'mass' => 1.5,
            'link' => 'http://space.skyrocket.de/doc_sdat/perseus-000.htm'
        ]);

        Payload::create([
            'mission_id' => 7,
            'name' => 'Perseus 002',
            'operator' => "Los Alamos National Laboratory",
            'primary' => false,
            'mass' => 1.5,
            'link' => 'http://space.skyrocket.de/doc_sdat/perseus-000.htm'
        ]);

        Payload::create([
            'mission_id' => 7,
            'name' => 'Perseus 003',
            'operator' => "Los Alamos National Laboratory",
            'primary' => false,
            'mass' => 1.5,
            'link' => 'http://space.skyrocket.de/doc_sdat/perseus-000.htm'
        ]);

        Payload::create([
            'mission_id' => 8,
            'name' => 'Celestis 11',
            'operator' => "Celestis",
            'primary' => false,
            'link' => 'http://space.skyrocket.de/doc_sdat/celestis-11.htm'
        ]);

        Payload::create([
            'mission_id' => 9,
            'name' => 'Orbcomm OG2 1 (H1)',
            'operator' => "Orbcomm",
            'primary' => false,
            'mass' => 172,
            'link' => 'http://space.skyrocket.de/doc_sdat/orbcomm-2.htm'
        ]);
    }
}