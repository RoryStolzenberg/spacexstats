<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Destination;
use SpaceXStats\Models\Location;
use SpaceXStats\Models\Mission;
use SpaceXStats\Models\MissionType;
use SpaceXStats\Library\Enums\MissionOutcome;
use SpaceXStats\Library\Enums\MissionStatus;
use SpaceXStats\Library\Enums\MissionType as MissionTypeEnum;
use SpaceXStats\Library\Enums\Destination as DestinationEnum;

class MissionsTableSeeder extends Seeder {
    public function run() {
        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DemoFlight)->firstOrFail()->mission_type_id,
            'launch_order_id' => 1,
            'launch_exact' => Carbon::create(2006, 3, 24, 22, 30, 0),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'FalconSAT-2',
            'contractor' => 'SpaceX',
            'vehicle_id' => 1,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'Omelek Island')->firstOrFail()->location_id,
            'summary' => "SpaceX's first launch, which ended in disaster 25 seconds after launch due to an engine issue.",
            'article' => "Here's an article",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Failure
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DemoFlight)->firstOrFail()->mission_type_id,
            'launch_order_id' => 2,
            'launch_exact' => Carbon::create(2007, 3, 21, 1, 10, 0),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'Demo Sat',
            'contractor' => 'SpaceX',
            'vehicle_id' => 1,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'Omelek Island')->firstOrFail()->location_id,
            'summary' => "The second launch of Falcon 1, attempted (and failed to) carry a mass simulator into orbit.",
            'article' => "Here's an article",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Failure
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DemoFlight)->firstOrFail()->mission_type_id,
            'launch_order_id' => 3,
            'launch_exact' => Carbon::create(2008, 8, 3, 3, 34, 0),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'Falcon 1 Flight 3',
            'contractor' => 'SpaceX',
            'vehicle_id' => 1,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'Omelek Island')->firstOrFail()->location_id,
            'summary' => "Flight 3 of Falcon 1 was to place a quadro of small satellites into Earth orbit, but again failed.",
            'article' => "Here's an article",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Failure
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DemoFlight)->firstOrFail()->mission_type_id,
            'launch_order_id' => 4,
            'launch_exact' => Carbon::create(2008, 9, 28, 23, 15, 0),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'RatSat',
            'contractor' => 'SpaceX',
            'vehicle_id' => 1,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'Omelek Island')->firstOrFail()->location_id,
            'summary' => "The first privately-developed liquid fueled rocket to reach orbit.",
            'article' => "Here's an article",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::Scientific)->firstOrFail()->mission_type_id,
            'launch_order_id' => 5,
            'launch_exact' => Carbon::create(2009, 7, 14, 3, 35, 0),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'RAZAKSat',
            'contractor' => 'SpaceX',
            'vehicle_id' => 1,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'Omelek Island')->firstOrFail()->location_id,
            'summary' => "Final launch of Falcon 1 and SpaceX's second successful flight and first satellite in orbit.",
            'article' => "Here's an article",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DemoFlight)->firstOrFail()->mission_type_id,
            'launch_order_id' => 6,
            'launch_exact' => Carbon::create(2010, 6, 4, 18, 45, 0),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'DSQU',
            'contractor' => 'SpaceX',
            'vehicle_id' => 2,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "First launch of the new Falcon 9 from Cape Canaveral delivering the Dragon Spacecraft Qualification Unit into orbit.",
            'article' => "Here's an article",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonFreeflight)->firstOrFail()->mission_type_id,
            'launch_order_id' => 7,
            'launch_exact' => Carbon::create(2010, 12, 8, 15, 43, 0),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'COTS Demo 1',
            'contractor' => 'SpaceX',
            'vehicle_id' => 2,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "Second launch of Falcon 9, and first launch of Dragon spacecraft into Low Earth Orbit.",
            'article' => "Here's an article",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 8,
            'launch_exact' => Carbon::create(2012, 5, 22, 7, 44, 38),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'COTS Demo 2+',
            'contractor' => 'SpaceX',
            'vehicle_id' => 2,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "First night Falcon 9 liftoff, and first private spacecraft to dock with the International Space Station.",
            'article' => "Here's an article",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 9,
            'launch_exact' => Carbon::create(2012, 10, 8, 0, 34, 7),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'SpaceX CRS-1',
            'contractor' => 'NASA',
            'vehicle_id' => 2,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => 'First of twelve initially contracted International Space Station resupply missions with Dragon. Demonstration of engine out capability.',
            'article' => "Here's an article",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
        ]);

        Mission::create(array(
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 10,
            'launch_exact' => Carbon::create(2013, 3, 1, 15, 10, 0),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'SpaceX CRS-2',
            'contractor' => 'NASA',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => 'Second contracted flight of Dragon, and the fifth and last flight of Falcon 9 v1.0',
            'article' => "Here's an article",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
        ));

        Mission::create(array(
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::Scientific)->firstOrFail()->mission_type_id,
            'launch_order_id' => 11,
            'launch_exact' => Carbon::create(2013, 9, 29, 16, 0, 0),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'CASSIOPE',
            'contractor' => 'MDA Corp.',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', 'Polar Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-4E')->firstOrFail()->location_id,
            'summary' => 'First Falcon 9v1.1 launch from Vandenberg delivering CASSIOPE satellite into a polar orbit with a new payload fairing. Attempt at propulsive over-water soft landing.',
            'article' => "Here's an article",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
        ));

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 12,
            'launch_exact' => Carbon::now()->addWeek(),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'SES-8',
            'contractor' => 'SES World Skies',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::SupersynchronousGTO)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => 'default summary',
            'article' => "default summary",
            'status' => MissionStatus::Upcoming,
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 13,
            'launch_exact' => Carbon::now()->addMonth(),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'Thaicom-6',
            'contractor' => 'Thaicom',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::SupersynchronousGTO)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => 'default summary',
            'article' => "default summary",
            'status' => MissionStatus::Upcoming,
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 14,
            'launch_exact' => Carbon::now()->addMonths(2),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'SpaceX CRS-3',
            'contractor' => 'NASA',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbitISS)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => 'default summary',
            'article' => "default summary",
            'status' => MissionStatus::Upcoming,
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::ConstellationMission)->firstOrFail()->mission_type_id,
            'launch_order_id' => 15,
            'launch_exact' => Carbon::now()->addMonths(3),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'Orbcomm OG2 Launch 1',
            'contractor' => 'Orbcomm',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => 'default summary',
            'article' => "default summary",
            'status' => MissionStatus::Upcoming,
        ]);
    }
}