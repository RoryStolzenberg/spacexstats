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
            'firststage_engine' => Engine::Kestrel,
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
            'firststage_engine' => Engine::Kestrel,
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
            'firststage_engine' => Engine::Kestrel,
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
            'firststage_engine' => Engine::Kestrel,
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
            'firststage_engine' => Engine::Kestrel,
            'landed' => false
        ));

        // Falcon 9 v1.0 partflights

        // Falcon 9 v1.1 partflights

        // Falcon 9 post-CRS7 partflights
    }
}