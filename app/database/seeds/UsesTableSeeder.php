<?php
class UsesTableSeeder extends Seeder {
    public function run() {
        Uses::create(array(
            'mission_id' => 1,
            'core_id' => 1,
            'firststage_engine' => 'Merlin 1C'
        ));

        Uses::create(array(
            'mission_id' => 2,
            'core_id' => 2,
            'firststage_engine' => 'Merlin 1C'
        ));

        Uses::create(array(
            'mission_id' => 3,
            'core_id' => 3,
            'firststage_engine' => 'Merlin 1C'
        ));

        Uses::create(array(
            'mission_id' => 4,
            'core_id' => 4,
            'firststage_engine' => 'Merlin 1C'
        ));

    }
}