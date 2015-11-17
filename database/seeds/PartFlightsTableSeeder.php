<?php
use Illuminate\Database\Seeder;
use SpaceXStats\Models\PartFlight;
use SpaceXStats\Library\Enums\Engine;

class PartFlightsTableSeeder extends Seeder {
    public function run() {
        // Falcon 1 (add in MECO/SECO values here, along with anything else (check the $table Blueprint in the spacexstats migration)
        PartFlight::create(array(
            'mission_id' => 1,
            'part_id' => 1,
            'firststage_engine' => Engine::Merlin1A,
            'firststage_engine_failures' => 1,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 1,
            'part_id' => 2,
            'upperstage_engine' => Engine::Kestrel,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 2,
            'part_id' => 3,
            'firststage_engine' => Engine::Merlin1A,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 2,
            'part_id' => 4,
            'upperstage_engine' => Engine::Kestrel,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 3,
            'part_id' => 5,
            'firststage_engine' => Engine::Merlin1CF1,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 3,
            'part_id' => 6,
            'upperstage_engine' => Engine::Kestrel,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 4,
            'part_id' => 7,
            'firststage_engine' => Engine::Merlin1CF1,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 4,
            'part_id' => 8,
            'upperstage_engine' => Engine::Kestrel,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 5,
            'part_id' => 9,
            'firststage_engine' => Engine::Merlin1CF1,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 5,
            'part_id' => 10,
            'upperstage_engine' => Engine::Kestrel,
            'landed' => false
        ));

        // Falcon 9 v1.0 partflights
        PartFlight::create(array(
            'mission_id' => 6,
            'part_id' => 11,
            'firststage_engine' => Engine::Merlin1CF9,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 6,
            'part_id' => 12,
            'upperstage_engine' => Engine::Merlin1CVac,
            'landed' => false
        ));

        // Falcon 9 v1.1 partflights

        // Falcon 9 post-CRS7 partflights
    }
}