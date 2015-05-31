<?php
class CoresTableSeeder extends Seeder {
    public function run() {
        Core::create(array(
            'name' => 'F9-001'
        ));

        Core::create(array(
            'name' => 'F9-002'
        ));

        Core::create(array(
            'name' => 'F9-003'
        ));
    }
}