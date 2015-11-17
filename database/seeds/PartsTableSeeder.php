<?php
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Part;
use SpaceXStats\Library\Enums\PartType;

class PartsTableSeeder extends Seeder {
    public function run() {

        // Falcon 1 Parts
        Part::create(array(
            'name' => 'F1-001',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F1-001-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F1-002',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F1-002-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F1-003',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F1-003-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F1-004',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F1-004-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F1-005',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F1-005-US',
            'type' => PartType::UpperStage
        ));

        // Falcon 9 v1.0 parts
        Part::create(array(
            'name' => 'F9-001',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-001-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-002',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-002-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-003',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-003-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-004',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-004-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-005',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-005-US',
            'type' => PartType::UpperStage
        ));

        // Falcon 9 v1.1 parts (CRS-4 core switch)

        // Post Jason-3 parts (v1.2)

    }
}