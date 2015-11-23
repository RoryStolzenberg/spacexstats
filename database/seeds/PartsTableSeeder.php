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

        // Falcon 9 v1.1 parts
        Part::create(array(
            'name' => 'F9-006',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-006-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-007',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-007-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-008',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-008-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-009',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-009-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-010',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-010-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-011',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-011-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-012',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-012-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-013',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-013-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-014',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-014-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-015',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-015-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-016',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-016-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-017',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-017-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-018',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-018-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-019',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-019-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-020',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-020-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-021',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-021-US',
            'type' => PartType::UpperStage
        ));

        Part::create(array(
            'name' => 'F9-022',
            'type' => PartType::FirstStage
        ));

        Part::create(array(
            'name' => 'F9-022-US',
            'type' => PartType::UpperStage
        ));
    }
}