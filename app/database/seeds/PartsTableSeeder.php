<?php
class PartsTableSeeder extends Seeder {
    public function run() {
        Part::create(array(
            'name' => 'F9-001',
            'type' => 'First Stage'
        ));

        Part::create(array(
            'name' => 'F9-002',
            'type' => 'First Stage'
        ));

        Part::create(array(
            'name' => 'F9-003',
            'type' => 'First Stage'
        ));

        Part::create(array(
            'name' => 'F9-004',
            'type' => 'First Stage'
        ));
    }
}