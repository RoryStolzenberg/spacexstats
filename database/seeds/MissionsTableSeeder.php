<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use SpaceXStats\Library\Enums\LaunchSpecificity;
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
            'launch_illumination' => 'Day',
            'summary' => "SpaceX's first launch, which ended in disaster 25 seconds after launch due to an engine issue.",
            'article' => file_get_contents(base_path('resources/assets/documents/falcon1flight1.txt')),
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Failure,
            'flight_club' => 'http://www.flightclub.io/results.php?id=1fb6ce16-55d5-4391-9c96-154a98d46995&code=FSAT'
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
            'launch_illumination' => 'Day',
            'summary' => "The second launch of Falcon 1, attempted (and failed to) carry a mass simulator into orbit.",
            'article' => file_get_contents(base_path('resources/assets/documents/falcon1flight2.txt')),
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Failure,
            'flight_club' => 'http://www.flightclub.io/results.php?id=1ae6c87d-5c53-446b-a2fa-393750ceab60&code=DEMO'
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
            'launch_illumination' => 'Day',
            'summary' => "Flight 3 of Falcon 1 was to place a quadro of small satellites into Earth orbit, but again failed.",
            'article' => file_get_contents(base_path('resources/assets/documents/falcon1flight3.txt')),
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Failure,
            'flight_club' => 'http://www.flightclub.io/results.php?id=99ea6398-1f8f-44c2-b00b-b87b781ade8e&code=TBZR'
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
            'launch_illumination' => 'Day',
            'summary' => "The first privately-developed liquid fueled rocket to reach orbit.",
            'article' => file_get_contents(base_path('resources/assets/documents/falcon1flight4.txt')),
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=a3247ff9-b134-4be3-9899-e2fafda69ee5&code=RATS'
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::Scientific)->firstOrFail()->mission_type_id,
            'launch_order_id' => 5,
            'launch_exact' => Carbon::create(2009, 7, 14, 3, 35, 0),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'RazakSAT',
            'contractor' => 'SpaceX',
            'vehicle_id' => 1,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'Omelek Island')->firstOrFail()->location_id,
            'launch_illumination' => 'Day',
            'summary' => "Final launch of Falcon 1 and SpaceX's second successful flight and first satellite in orbit.",
            'article' => file_get_contents(base_path('resources/assets/documents/falcon1flight5.txt')),
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=dc4d2483-7835-400c-8d9c-f1abb26a3fd8&code=RAZS'
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
            'launch_illumination' => 'Day',
            'summary' => "First launch of the new Falcon 9 from Cape Canaveral delivering the Dragon Spacecraft Qualification Unit into orbit.",
            'article' => file_get_contents(base_path('resources/assets/documents/dsqu.txt')),
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=b23bd90a-60a5-43bc-8c99-8eaa6add53ca&code=F9F1'
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
            'launch_illumination' => 'Day',
            'summary' => "Second launch of Falcon 9, and first launch of Dragon spacecraft into Low Earth Orbit.",
            'article' => file_get_contents(base_path('resources/assets/documents/cots1.txt')),
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=270d3400-4d15-4f2b-8b54-b2af12286fea&code=COT1'
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
            'launch_illumination' => 'Night',
            'summary' => "First night Falcon 9 liftoff, and first private spacecraft to dock with the International Space Station.",
            'article' => file_get_contents(base_path('resources/assets/documents/cots2+.txt')),
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=76b9675a-7e6d-458f-bb2d-22281b7d4bb4&code=COT2'
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
            'launch_illumination' => 'Day',
            'summary' => 'First of twelve initially contracted International Space Station resupply missions with Dragon. Demonstration of engine out capability.',
            'article' => file_get_contents(base_path('resources/assets/documents/crs1.txt')),
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=cd6f5ea1-2cc6-4b16-ae7e-0254328365d2&code=CRS1'
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
            'launch_illumination' => 'Day',
            'summary' => 'Second contracted flight of Dragon, and the fifth and last flight of Falcon 9 v1.0',
            'article' => file_get_contents(base_path('resources/assets/documents/crs2.txt')),
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=f6aa4e89-33ca-48c4-a545-df34364913ff&code=CRS2'
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
            'launch_illumination' => 'Day',
            'summary' => 'First Falcon 9v1.1 launch from Vandenberg delivering CASSIOPE satellite into a polar orbit with a new payload fairing. Attempt at propulsive over-water soft landing.',
            'article' => file_get_contents(base_path('resources/assets/documents/cassiope.txt')),
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=89b1bbdc-7d1a-4c1d-8b2f-3b3d65ac39ab&code=CASS'
        ));

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 12,
            'launch_exact' => Carbon::create(2013, 12, 3, 22, 41, 0),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'SES-8',
            'contractor' => 'SES World Skies',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::SupersynchronousGTO)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'launch_illumination' => 'Twilight',
            'summary' => 'Second Falcon 9v1.1 launch, first from Cape Canaveral. Other firsts include achieving a GTO orbit, a Merlin 1D upper stage restart, and a communications satellite payload. ',
            'article' => file_get_contents(base_path('resources/assets/documents/ses8.txt')),
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=2799bd61-39db-40ce-aedb-4e9fe0ddb759&code=SES8'
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 13,
            'launch_exact' => Carbon::create(2014, 1, 6, 22, 6, 0),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'Thaicom 6',
            'contractor' => 'Thaicom',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::SupersynchronousGTO)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'launch_illumination' => 'Day',
            'summary' => 'Third Falcon 9v1.1 launch, 8th Falcon 9. Delivered the communications satellite Thaicom 6 into a "supersynchronous" GTO orbit similar to SES-8. ',
            'article' => file_get_contents(base_path('resources/assets/documents/thaicom6.txt')),
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=678a6c1e-4442-4c66-9ddb-840032673ec8&code=THM6'
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 14,
            'launch_exact' => Carbon::create(2014, 4, 18, 19, 25, 21),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'SpaceX CRS-3',
            'contractor' => 'NASA',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbitISS)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'launch_illumination' => 'Day',
            'summary' => 'Third Dragon CRS mission to the ISS. First resupply utilizing a Falcon 9v1.1, allowing Dragon to carry a larger capacity of cargo.',
            'article' => file_get_contents(base_path('resources/assets/documents/crs3.txt')),
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=786f9b59-cb08-4c18-9615-704205259f70&code=CRS3'
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::ConstellationMission)->firstOrFail()->mission_type_id,
            'launch_order_id' => 15,
            'launch_exact' => Carbon::create(2014, 7, 14, 15, 15, 0),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'Orbcomm OG2 Launch 1',
            'contractor' => 'Orbcomm',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'launch_illumination' => 'Day',
            'summary' => 'A Falcon 9 flew the first 6 Orbcomm G2 satellites into a Low Earth Orbit as part of a multi-mission contract for the communications corporation.',
            'article' => file_get_contents(base_path('resources/assets/documents/orbcommog2launch1.txt')),
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=ca97c97e-f1a3-42e8-abbf-b92df9383cc7&code=OG21'
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 16,
            'launch_exact' => Carbon::create(2014, 8, 5, 8, 0, 0),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'AsiaSat 8',
            'contractor' => 'Asia Satellite Telecommunications Company',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'launch_illumination' => 'Night',
            'summary' => 'AsiaSat 8 is a communications satellite that Falcon 9 propelled into a GTO orbit, and will be located at 105.5 degrees East.',
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=e0030f94-88c9-4bda-9973-cdc7d189a992&code=AST8'
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 17,
            'launch_exact' => Carbon::create(2014, 9, 7, 5, 0, 0),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'AsiaSat 6',
            'contractor' => 'Asia Satellite Telecommunications Company',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'launch_illumination' => 'Night',
            'summary' => 'AsiaSat 6 is a communications satellite being launched for Asia Satellite Telecommunications Company Ltd. Once in orbit, it will be renamed AsiaSat 6 / Thaicom 7.',
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=aa44b8b5-25bf-453e-9ca4-2510848fb145&code=AST6'
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 18,
            'launch_exact' => Carbon::create(2014, 9, 21, 5, 52, 3),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'SpaceX CRS-4',
            'contractor' => 'NASA',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbitISS)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'launch_illumination' => 'Night',
            'summary' => 'Fourth of twelve Dragon ISS resupply missions. It is carrying over 5000 pounds to the station, including 20 mousetronauts, and the SpinSat satellite.',
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=dc88c2c3-9919-44dd-9893-0738518a28d6&code=CRS4'
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 19,
            'launch_exact' => Carbon::create(2015, 1, 10, 9, 47, 10),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'SpaceX CRS-5',
            'contractor' => 'NASA',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbitISS)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'launch_illumination' => 'Night',
            'summary' => 'The fifth CRS mission to the ISS will carry pressurized and unpressurized cargo to the station. Secondary payloads include 2 small satellites to be deployed from the ISS airlock.', 'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=d8fad388-cdcd-442e-a1b0-a404ade89070&code=CRS5'
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::Scientific)->firstOrFail()->mission_type_id,
            'launch_order_id' => 20,
            'launch_exact' => Carbon::create(2015, 2, 11, 23, 3, 32),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'DSCOVR',
            'contractor' => 'NOAA',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::EarthSunL1)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'launch_illumination' => 'Day',
            'summary' => 'Falcon 9 will loft the much-delayed Deep Space Climate Observatory to Sun-Earth L1 for NOAA, where it will function as an Earth & Solar Observation satellite.',
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=0248fc77-b30a-4e45-a55c-c8c6c2e2efba&code=DSCR'
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 21,
            'launch_exact' => Carbon::create(2015, 3, 2, 3, 50, 0),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'Eutelsat 115W B & ABS-3A',
            'contractor' => 'Asia Broadcast Satellite',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'launch_illumination' => 'Night',
            'summary' => "This marks SpaceX's first dual comm. satellite launch, of Eutelsat 115W B & ABS-3A. The satellites, built by Boeing, use Solar Electric Propulsion, making it feasible to fit both on a single Falcon 9 and removing the need for weighty Hydrazine.",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=2466b6b0-d440-495c-890f-23577087924d&code=EUAB'
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 22,
            'launch_exact' => Carbon::create(2015, 4, 14, 20, 10, 41),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'SpaceX CRS-6',
            'contractor' => 'NASA',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbitISS)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'launch_illumination' => 'Day',
            'summary' => "The sixth of fourteen Dragon ISS resupply missions to the ISS. Will attempt a barge landing on ASDS.",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=4713410a-e452-484e-86be-3bb95ea3c5e8&code=CRS6'
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 23,
            'launch_exact' => Carbon::create(2015, 4, 27, 23, 3, 0),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => utf8_encode('TurkmenÄlem 52E'),
            'contractor' => 'Thales Alenia Space (Turkmenistan)',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'launch_illumination' => 'Day',
            'summary' => "A Falcon 9 will launch Turkmenistan's first communications satellite into GTO orbit in April 2015.",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
            'flight_club' => 'http://www.flightclub.io/results.php?id=eb98b985-210f-416c-a118-14eb1afbb1c8&code=TRK1'
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 24,
            'launch_exact' => Carbon::create(2015, 6, 28, 14, 21, 11),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'SpaceX CRS-7',
            'contractor' => 'NASA',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbitISS)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'launch_illumination' => 'Day',
            'summary' => "A Falcon 9 will launch Turkmenistan's first communications satellite into GTO orbit in April 2015.",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Failure,
            'flight_club' => 'http://www.flightclub.io/results.php?id=ad8d5e76-ad6b-4670-9aee-60c1319dff50&code=CRS7'
        ]);

        // Upcoming below
        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::ConstellationMission)->firstOrFail()->mission_type_id,
            'launch_order_id' => 25,
            'launch_exact' => Carbon::create(2015, 12, 11, 0, 0, 0),
            'launch_approximate' => null,
            'launch_specificity' => 6,
            'name' => 'Orbcomm OG2 Launch 2',
            'contractor' => 'Orbcomm',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "SpaceX's Return To Flight Mission",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 26,
            'launch_exact' => null,
            'launch_approximate' => 'late December 2015',
            'launch_specificity' => LaunchSpecificity::SubMonth,
            'name' => 'SES-9',
            'contractor' => 'SES',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::SubsynchronousGTO)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "SES's second launch",
            'status' => MissionStatus::Upcoming
        ]);


        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::Scientific)->firstOrFail()->mission_type_id,
            'launch_order_id' => 27,
            'launch_exact' => Carbon::create(2016, 1, 4, 0, 0, 0),
            'launch_approximate' => null,
            'launch_specificity' => LaunchSpecificity::Day,
            'name' => 'Jason 3',
            'contractor' => 'NASA',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::PolarOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-4E')->firstOrFail()->location_id,
            'summary' => "Launching Jason-3 to polar",
            'status' => MissionStatus::Upcoming
        ]);
        // Ordered above
        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 28,
            'launch_exact' => null,
            'launch_approximate' => 'January 2016',
            'launch_specificity' => LaunchSpecificity::Month,
            'name' => 'SpaceX CRS-8',
            'contractor' => 'NASA',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbitISS)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "8th mission to the ISS",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 29,
            'launch_exact' => Carbon::create(2016, 3, 21, 0, 0, 0),
            'launch_approximate' => null,
            'launch_specificity' => LaunchSpecificity::Day,
            'name' => 'SpaceX CRS-9',
            'contractor' => 'NASA',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbitISS)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "SpaceX CRS-9",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::Rideshare)->firstOrFail()->mission_type_id,
            'launch_order_id' => 30,
            'launch_exact' => null,
            'launch_approximate' => 'Q1 2016',
            'launch_specificity' => LaunchSpecificity::Quarter,
            'name' => 'SHERPA Flight 1',
            'contractor' => 'Spaceflight Industries',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::PolarOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-4E')->firstOrFail()->location_id,
            'summary' => "SHERPA Flight 1",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DemoFlight)->firstOrFail()->mission_type_id,
            'launch_order_id' => 31,
            'launch_exact' => null,
            'launch_approximate' => 'May 2016',
            'launch_specificity' => LaunchSpecificity::Month,
            'name' => 'Falcon Heavy Test Flight',
            'contractor' => 'SpaceX',
            'vehicle_id' => 5,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'LC-39A')->firstOrFail()->location_id,
            'summary' => "Falcon Heavy test flight",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 32,
            'launch_exact' => Carbon::create(2016, 6, 10, 0, 0, 0),
            'launch_approximate' => null,
            'launch_specificity' => LaunchSpecificity::Day,
            'name' => 'SpaceX CRS-10',
            'contractor' => 'NASA',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbitISS)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "SpaceX CRS-10",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 33,
            'launch_exact' => Carbon::create(2016, 8, 15, 0, 0, 0),
            'launch_approximate' => null,
            'launch_specificity' => LaunchSpecificity::Day,
            'name' => 'SpaceX CRS-11',
            'contractor' => 'NASA',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbitISS)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "SpaceX CRS-11",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 34,
            'launch_exact' => null,
            'launch_approximate' => 'Mid 2016',
            'launch_specificity' => LaunchSpecificity::SubYear,
            'name' => 'AMOS-6',
            'contractor' => 'Spacecom Ltd',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "AMOS-6",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::Rideshare)->firstOrFail()->mission_type_id,
            'launch_order_id' => 35,
            'launch_exact' => Carbon::create(2016, 9, 15, 0, 0, 0),
            'launch_approximate' => null,
            'launch_specificity' => LaunchSpecificity::Day,
            'name' => 'STP-2',
            'contractor' => 'U.S. Air Force',
            'vehicle_id' => 5,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'LC-39A')->firstOrFail()->location_id,
            'summary' => "STP-2",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 36,
            'launch_exact' => Carbon::create(2016, 10, 31, 0, 0, 0),
            'launch_approximate' => null,
            'launch_specificity' => LaunchSpecificity::Day,
            'name' => 'SES-10',
            'contractor' => 'SES World Skies',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::SubsynchronousGTO)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "SES-10",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 37,
            'launch_exact' => Carbon::create(2016, 12, 19, 0, 0, 0),
            'launch_approximate' => null,
            'launch_specificity' => LaunchSpecificity::Day,
            'name' => 'SpaceX CRS-12',
            'contractor' => 'NASA',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbitISS)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "SpaceX CRS-12",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CrewDragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 38,
            'launch_exact' => Carbon::create(2016, 12, 31, 0, 0, 0),
            'launch_approximate' => null,
            'launch_specificity' => LaunchSpecificity::Day,
            'name' => 'EchoStar 105/SES-11',
            'contractor' => 'SES World Skies',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "EchoStar 105/SES-11",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DemoFlight)->firstOrFail()->mission_type_id,
            'launch_order_id' => 39,
            'launch_exact' => null,
            'launch_approximate' => 'December 2016',
            'launch_specificity' => LaunchSpecificity::Month,
            'name' => 'CCtCap Demo Mission 1',
            'contractor' => 'NASA',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbitISS)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "CCtCap Demo Mission 1",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 40,
            'launch_exact' => null,
            'launch_approximate' => 'Late 2016',
            'launch_specificity' => LaunchSpecificity::SubYear,
            'name' => "Es'hail 2",
            'contractor' => "Es’hailSat",
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "Es'hail 2",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 41,
            'launch_exact' => null,
            'launch_approximate' => '2016',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => "EuropaSat / HellasSat 3",
            'contractor' => "Inmarsat & ArabSat",
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "EuropaSat / HellasSat 3",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 42,
            'launch_exact' => null,
            'launch_approximate' => '2016',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => "Inmarsat-5 F4",
            'contractor' => "Inmarsat",
            'vehicle_id' => 5,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'LC-39A')->firstOrFail()->location_id,
            'summary' => "Inmarsat-5 F4",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 43,
            'launch_exact' => null,
            'launch_approximate' => '2016',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => "Unknown Intelsat Satellite",
            'contractor' => "Intelsat",
            'vehicle_id' => 5,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'LC-39A')->firstOrFail()->location_id,
            'summary' => "Intelsat",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::ConstellationMission)->firstOrFail()->mission_type_id,
            'launch_order_id' => 44,
            'launch_exact' => null,
            'launch_approximate' => '2016',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => "Iridium NEXT Flight 1",
            'contractor' => "Iridium",
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::PolarOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-4E')->firstOrFail()->location_id,
            'summary' => "Iridium NEXT Flight 1",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::ConstellationMission)->firstOrFail()->mission_type_id,
            'launch_order_id' => 45,
            'launch_exact' => null,
            'launch_approximate' => '2016',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => "Iridium NEXT Flight 2",
            'contractor' => "Iridium",
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::PolarOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-4E')->firstOrFail()->location_id,
            'summary' => "Iridium NEXT Flight 2",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::ConstellationMission)->firstOrFail()->mission_type_id,
            'launch_order_id' => 46,
            'launch_exact' => null,
            'launch_approximate' => '2016',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => "Iridium NEXT Flight 3",
            'contractor' => "Iridium",
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::PolarOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-4E')->firstOrFail()->location_id,
            'summary' => "Iridium NEXT Flight 3",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 47,
            'launch_exact' => null,
            'launch_approximate' => '2016',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => 'Eutelsat 117W B & ABS-2A',
            'contractor' => 'Asia Broadcast Satellite',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "Eutelsat 117W B & ABS-2A",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 48,
            'launch_exact' => null,
            'launch_approximate' => '2016',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => 'JCSAT-14',
            'contractor' => 'SKY Perfect JSAT Corparation',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "JCSAT-14",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::Scientific)->firstOrFail()->mission_type_id,
            'launch_order_id' => 49,
            'launch_exact' => null,
            'launch_approximate' => '2016',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => 'SAOCOM 1A',
            'contractor' => 'CONAE (Argentina)',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::PolarOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-4E')->firstOrFail()->location_id,
            'summary' => "SAOCOM 1A",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 50,
            'launch_exact' => null,
            'launch_approximate' => '2016',
            'launch_specificity' => LaunchSpecificity::SubYear,
            'name' => 'BulgariaSat-1',
            'contractor' => 'Bulgaria Sat',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "BulgariaSat-1",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 51,
            'launch_exact' => null,
            'launch_approximate' => '2016',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => 'JCSAT-16',
            'contractor' => 'SKY Perfect JSAT Corparation',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "JCSAT-16",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 52,
            'launch_exact' => null,
            'launch_approximate' => '2016',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => 'KoreaSat-5A',
            'contractor' => 'KT Sat',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "KoreaSat-5A",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 53,
            'launch_exact' => null,
            'launch_approximate' => '2016',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => 'Thaicom 8',
            'contractor' => 'Thaicom',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "Thaicom",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 54,
            'launch_exact' => null,
            'launch_approximate' => '2016',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => 'ViaSat 2',
            'contractor' => 'ViaSat Inc.',
            'vehicle_id' => 5,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'LC-39A')->firstOrFail()->location_id,
            'summary' => "ViaSat 2",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::Scientific)->firstOrFail()->mission_type_id,
            'launch_order_id' => 55,
            'launch_exact' => null,
            'launch_approximate' => 'August 2017',
            'launch_specificity' => LaunchSpecificity::Month,
            'name' => 'Transiting Exoplanet Survey Satellite (TESS)',
            'contractor' => 'NASA',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::Lunar)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "Transiting Exoplanet Survey Satellite (TESS)",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 56,
            'launch_exact' => Carbon::create(2017, 10, 1, 0, 0, 0),
            'launch_approximate' => null,
            'launch_specificity' => LaunchSpecificity::Day,
            'name' => 'SES-14/GOLD',
            'contractor' => 'SES World Skies',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "SES-14/GOLD",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 57,
            'launch_exact' => null,
            'launch_approximate' => 'Late 2017',
            'launch_specificity' => LaunchSpecificity::SubYear,
            'name' => 'HISPASAT-1F',
            'contractor' => 'HISPASAT Group',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "HISPASAT-1F",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::Scientific)->firstOrFail()->mission_type_id,
            'launch_order_id' => 58,
            'launch_exact' => null,
            'launch_approximate' => 'H2 2017',
            'launch_specificity' => LaunchSpecificity::Half,
            'name' => 'SpaceIL Lunar Lander (GLXP)',
            'contractor' => 'SpaceIL',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::Lunar)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "SpaceIL Lunar Lander (GLXP)",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DemoFlight)->firstOrFail()->mission_type_id,
            'launch_order_id' => 59,
            'launch_exact' => null,
            'launch_approximate' => '2017',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => 'Dragon Inflight Abort',
            'contractor' => 'SpaceX / NASA',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::Suborbital)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-4E')->firstOrFail()->location_id,
            'summary' => "Dragon Inflight Abort",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 60,
            'launch_exact' => null,
            'launch_approximate' => '2017',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => 'SpaceX CRS-13',
            'contractor' => 'NASA',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbitISS)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "SpaceX CRS-13",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 61,
            'launch_exact' => null,
            'launch_approximate' => '2017',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => 'SpaceX CRS-14',
            'contractor' => 'NASA',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbitISS)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "SpaceX CRS-14",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 62,
            'launch_exact' => null,
            'launch_approximate' => '2017',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => 'SpaceX CRS-15',
            'contractor' => 'NASA',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbitISS)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "SpaceX CRS-15",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CrewDragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 63,
            'launch_exact' => null,
            'launch_approximate' => '2017',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => 'Demonstration Mission 2',
            'contractor' => 'NASA',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbitISS)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "Demonstration Mission 2",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::ConstellationMission)->firstOrFail()->mission_type_id,
            'launch_order_id' => 64,
            'launch_exact' => null,
            'launch_approximate' => '2017',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => "Iridium NEXT Flight 4",
            'contractor' => "Iridium",
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::PolarOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-4E')->firstOrFail()->location_id,
            'summary' => "Iridium NEXT Flight 4",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::ConstellationMission)->firstOrFail()->mission_type_id,
            'launch_order_id' => 65,
            'launch_exact' => null,
            'launch_approximate' => '2017',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => "Iridium NEXT Flight 5",
            'contractor' => "Iridium",
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::PolarOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-4E')->firstOrFail()->location_id,
            'summary' => "Iridium NEXT Flight 5",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::ConstellationMission)->firstOrFail()->mission_type_id,
            'launch_order_id' => 66,
            'launch_exact' => null,
            'launch_approximate' => '2017',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => "Iridium NEXT Flight 6",
            'contractor' => "Iridium",
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::PolarOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-4E')->firstOrFail()->location_id,
            'summary' => "Iridium NEXT Flight 6",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::ConstellationMission)->firstOrFail()->mission_type_id,
            'launch_order_id' => 67,
            'launch_exact' => null,
            'launch_approximate' => '2017',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => "Iridium NEXT Flight 7",
            'contractor' => "Iridium",
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::PolarOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-4E')->firstOrFail()->location_id,
            'summary' => "Iridium NEXT Flight 7",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 68,
            'launch_exact' => null,
            'launch_approximate' => '2017',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => 'PSN 6',
            'contractor' => 'PT Pasifik Satelit Nusantara (PSN)',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "PSN 6",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::Scientific)->firstOrFail()->mission_type_id,
            'launch_order_id' => 69,
            'launch_exact' => null,
            'launch_approximate' => '2018',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => 'SAOCOM 1B',
            'contractor' => 'CONAE (Argentina)',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::PolarOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-4E')->firstOrFail()->location_id,
            'summary' => "SAOCOM 1A",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::ConstellationMission)->firstOrFail()->mission_type_id,
            'launch_order_id' => 70,
            'launch_exact' => null,
            'launch_approximate' => '2018',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => 'Radarsat Constellation',
            'contractor' => 'Canada',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::PolarOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-4E')->firstOrFail()->location_id,
            'summary' => "Radarsat Constellation",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 71,
            'launch_exact' => null,
            'launch_approximate' => '2018',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => 'Arabsat 6A',
            'contractor' => 'Arab Satellite Communications Organization',
            'vehicle_id' => 5,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'LC-39A')->firstOrFail()->location_id,
            'summary' => "Arabsat 6A",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::Military)->firstOrFail()->mission_type_id,
            'launch_order_id' => 72,
            'launch_exact' => null,
            'launch_approximate' => '2018',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => 'SARah 1',
            'contractor' => 'Bundeswehr (German Intelligence)',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::PolarOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-4E')->firstOrFail()->location_id,
            'summary' => "SARah 1",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::Military)->firstOrFail()->mission_type_id,
            'launch_order_id' => 73,
            'launch_exact' => null,
            'launch_approximate' => '2019',
            'launch_specificity' => LaunchSpecificity::Year,
            'name' => 'SARah 2 & SARah 3',
            'contractor' => 'Bundeswehr (German Intelligence)',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::PolarOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-4E')->firstOrFail()->location_id,
            'summary' => "SARah 2 & SARah 3",
            'status' => MissionStatus::Upcoming
        ]);
    }
}