<?php
use Illuminate\Database\Seeder;
use SpaceXStats\Models\MissionType;
use SpaceXStats\Library\Enums\MissionType as MissionTypeEnum;

class MissionTypesTableSeeder extends Seeder {
    public function run() {

        // Any changes made here must also be reflected in SpaceXStats/Library/Enums/MissionType
        MissionType::insert(array(
            array('name' => MissionTypeEnum::DragonISS),
            array('name' => MissionTypeEnum::CrewDragonISS),
            array('name' => MissionTypeEnum::DragonFreeflight),
            array('name' => MissionTypeEnum::CommunicationsSatellite),
            array('name' => MissionTypeEnum::ConstellationMission),
            array('name' => MissionTypeEnum::SpaceXConstellationMission),
            array('name' => MissionTypeEnum::DemoFlight),
            array('name' => MissionTypeEnum::Military),
            array('name' => MissionTypeEnum::Scientific),
            array('name' => MissionTypeEnum::Mars),
            array('name' => MissionTypeEnum::Rideshare),
        ));
    }
}