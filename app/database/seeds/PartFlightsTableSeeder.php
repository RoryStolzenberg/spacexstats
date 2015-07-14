<?php
class PartFlightsTableSeeder extends Seeder {
    public function run() {
        PartFlight::create(array(
            'mission_id' => 1,
            'part_id' => 1,
            'firststage_engine' => 'Merlin 1C'
        ));

        PartFlight::create(array(
            'mission_id' => 2,
            'part_id' => 2,
            'firststage_engine' => 'Merlin 1C'
        ));

        PartFlight::create(array(
            'mission_id' => 3,
            'part_id' => 3,
            'firststage_engine' => 'Merlin 1C'
        ));

        PartFlight::create(array(
            'mission_id' => 3,
            'part_id' => 4,
            'firststage_engine' => 'Merlin 1C',
            'landed' => true
        ));

        PartFlight::create(array(
            'mission_id' => 4,
            'part_id' => 4,
            'firststage_engine' => 'Merlin 1C',
            'landed' => false
        ));
    }
}