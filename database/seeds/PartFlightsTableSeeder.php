<?php
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Part;
use SpaceXStats\Models\PartFlight;
use SpaceXStats\Library\Enums\Engine;

class PartFlightsTableSeeder extends Seeder {
    public function run() {
        // Falcon 1 Flight 1 (Done)
        PartFlight::create(array(
            'mission_id' => 1,
            'part_id' => 1,
            'firststage_engine' => Engine::Merlin1A,
            'firststage_engine_failures' => 1,
            'landed' => false,
            'note' => 'Destroyed on impact with Omelek Island reef, 80 metres from launch site'
        ));

        PartFlight::create(array(
            'mission_id' => 1,
            'part_id' => 2,
            'upperstage_engine' => Engine::Kestrel,
            'upperstage_status' => 'Did not achieve orbit',
            'landed' => false,
            'note' => 'Never used as failure occurred before MECO. Satellite carried with second stage crashed through the roof of the Payload Integration Building and was returned to DARPA'
        ));

        // Falcon 1 Flight 2
        PartFlight::create(array(
            'mission_id' => 2,
            'part_id' => 3,
            'firststage_engine' => Engine::Merlin1A,
            'landed' => false,
            'note' => 'Destroyed on reentry'
        ));

        PartFlight::create(array(
            'mission_id' => 2,
            'part_id' => 4,
            'upperstage_engine' => Engine::Kestrel,
            'upperstage_status' => 'Did not achieve orbit',
            'landed' => false,
            'note' => 'Destroyed on reentry'
        ));

        // Falcon 1 Flight 3
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

        // Falcon 1 Flight 4
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
            'upperstage_norad_id' => 33393,
            'landed' => false
        ));

        // Falcon 1 Flight 5
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

        // DSQU
        PartFlight::create(array(
            'mission_id' => 6,
            'part_id' => Part::where('name', 'F9-001')->first()->part_id,
            'firststage_engine' => Engine::Merlin1CF9,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 6,
            'part_id' => Part::where('name', 'F9-001-US')->first()->part_id,
            'upperstage_engine' => Engine::Merlin1CVac,
            'landed' => false
        ));

        // COTS1
        PartFlight::create(array(
            'mission_id' => 7,
            'part_id' => Part::where('name', 'F9-002')->first()->part_id,
            'firststage_engine' => Engine::Merlin1CF9,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 7,
            'part_id' => Part::where('name', 'F9-002-US')->first()->part_id,
            'upperstage_engine' => Engine::Merlin1CVac,
            'landed' => false
        ));

        // COTS2+
        PartFlight::create(array(
            'mission_id' => 8,
            'part_id' => Part::where('name', 'F9-003')->first()->part_id,
            'firststage_engine' => Engine::Merlin1CF9,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 8,
            'part_id' => Part::where('name', 'F9-003-US')->first()->part_id,
            'upperstage_engine' => Engine::Merlin1CVac,
            'landed' => false
        ));

        // CRS-1
        PartFlight::create(array(
            'mission_id' => 9,
            'part_id' => Part::where('name', 'F9-004')->first()->part_id,
            'firststage_engine' => Engine::Merlin1CF9,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 9,
            'part_id' => Part::where('name', 'F9-004-US')->first()->part_id,
            'upperstage_engine' => Engine::Merlin1CVac,
            'landed' => false
        ));

        // CRS-2
        PartFlight::create(array(
            'mission_id' => 10,
            'part_id' => Part::where('name', 'F9-005')->first()->part_id,
            'firststage_engine' => Engine::Merlin1CF9,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 10,
            'part_id' => Part::where('name', 'F9-005-US')->first()->part_id,
            'upperstage_engine' => Engine::Merlin1CVac,
            'landed' => false
        ));

        // CASSIOPE
        PartFlight::create(array(
            'mission_id' => 11,
            'part_id' => Part::where('name', 'F9-006')->first()->part_id,
            'firststage_engine' => Engine::Merlin1D,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 11,
            'part_id' => Part::where('name', 'F9-006-US')->first()->part_id,
            'upperstage_engine' => Engine::Merlin1DVac,
            'landed' => false
        ));

        // SES-8
        PartFlight::create(array(
            'mission_id' => 12,
            'part_id' => Part::where('name', 'F9-007')->first()->part_id,
            'firststage_engine' => Engine::Merlin1D,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 12,
            'part_id' => Part::where('name', 'F9-007-US')->first()->part_id,
            'upperstage_engine' => Engine::Merlin1DVac,
            'landed' => false
        ));

        // Thaicom 6
        PartFlight::create(array(
            'mission_id' => 13,
            'part_id' => Part::where('name', 'F9-008')->first()->part_id,
            'firststage_engine' => Engine::Merlin1D,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 13,
            'part_id' => Part::where('name', 'F9-008-US')->first()->part_id,
            'upperstage_engine' => Engine::Merlin1DVac,
            'landed' => false
        ));

        // CRS-3
        PartFlight::create(array(
            'mission_id' => 14,
            'part_id' => Part::where('name', 'F9-009')->first()->part_id,
            'firststage_engine' => Engine::Merlin1D,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 14,
            'part_id' => Part::where('name', 'F9-009-US')->first()->part_id,
            'upperstage_engine' => Engine::Merlin1DVac,
            'landed' => false
        ));

        // OG1
        PartFlight::create(array(
            'mission_id' => 15,
            'part_id' => Part::where('name', 'F9-010')->first()->part_id,
            'firststage_engine' => Engine::Merlin1D,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 15,
            'part_id' => Part::where('name', 'F9-010-US')->first()->part_id,
            'upperstage_engine' => Engine::Merlin1DVac,
            'landed' => false
        ));

        // AsiaSat 8
        PartFlight::create(array(
            'mission_id' => 16,
            'part_id' => Part::where('name', 'F9-011')->first()->part_id,
            'firststage_engine' => Engine::Merlin1D,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 16,
            'part_id' => Part::where('name', 'F9-011-US')->first()->part_id,
            'upperstage_engine' => Engine::Merlin1DVac,
            'landed' => false
        ));

        // AsiaSat 6
        PartFlight::create(array(
            'mission_id' => 17,
            'part_id' => Part::where('name', 'F9-013')->first()->part_id,
            'firststage_engine' => Engine::Merlin1D,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 17,
            'part_id' => Part::where('name', 'F9-013-US')->first()->part_id,
            'upperstage_engine' => Engine::Merlin1DVac,
            'landed' => false
        ));

        // CRS-4
        PartFlight::create(array(
            'mission_id' => 18,
            'part_id' => Part::where('name', 'F9-012')->first()->part_id,
            'firststage_engine' => Engine::Merlin1D,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 18,
            'part_id' => Part::where('name', 'F9-012-US')->first()->part_id,
            'upperstage_engine' => Engine::Merlin1DVac,
            'landed' => false
        ));

        // CRS-5
        PartFlight::create(array(
            'mission_id' => 19,
            'part_id' => Part::where('name', 'F9-014')->first()->part_id,
            'firststage_engine' => Engine::Merlin1D,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 19,
            'part_id' => Part::where('name', 'F9-014-US')->first()->part_id,
            'upperstage_engine' => Engine::Merlin1DVac,
            'landed' => false
        ));

        // DSCOVR
        PartFlight::create(array(
            'mission_id' => 20,
            'part_id' => Part::where('name', 'F9-015')->first()->part_id,
            'firststage_engine' => Engine::Merlin1D,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 20,
            'part_id' => Part::where('name', 'F9-015-US')->first()->part_id,
            'upperstage_engine' => Engine::Merlin1DVac,
            'landed' => false
        ));

        // EutelSat 115W B & ABS-3A
        PartFlight::create(array(
            'mission_id' => 21,
            'part_id' => Part::where('name', 'F9-016')->first()->part_id,
            'firststage_engine' => Engine::Merlin1D,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 21,
            'part_id' => Part::where('name', 'F9-016-US')->first()->part_id,
            'upperstage_engine' => Engine::Merlin1DVac,
            'landed' => false
        ));

        // CRS-6
        PartFlight::create(array(
            'mission_id' => 22,
            'part_id' => Part::where('name', 'F9-018')->first()->part_id,
            'firststage_engine' => Engine::Merlin1D,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 22,
            'part_id' => Part::where('name', 'F9-018-US')->first()->part_id,
            'upperstage_engine' => Engine::Merlin1DVac,
            'landed' => false
        ));

        // TurkmenAlem
        PartFlight::create(array(
            'mission_id' => 23,
            'part_id' => Part::where('name', 'F9-017')->first()->part_id,
            'firststage_engine' => Engine::Merlin1D,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 23,
            'part_id' => Part::where('name', 'F9-017-US')->first()->part_id,
            'upperstage_engine' => Engine::Merlin1DVac,
            'landed' => false
        ));

        // CRS-7
        PartFlight::create(array(
            'mission_id' => 23,
            'part_id' => Part::where('name', 'F9-020')->first()->part_id,
            'firststage_engine' => Engine::Merlin1D,
            'landed' => false
        ));

        PartFlight::create(array(
            'mission_id' => 23,
            'part_id' => Part::where('name', 'F9-020-US')->first()->part_id,
            'upperstage_engine' => Engine::Merlin1DVac,
            'landed' => false
        ));
    }
}