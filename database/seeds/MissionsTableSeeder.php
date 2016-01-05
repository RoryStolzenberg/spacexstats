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
            'summary' => "SpaceX's first ever launch  ended in disaster 25 seconds after launch when a crucial fuel line part corroded.",
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
            'summary' => "The second launch of Falcon 1 attempted (and failed to) carry a mass simulator into orbit, destroyed by a severe rotation that left the vehicle short of orbit.",
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
            'summary' => "Flight 3 of Falcon 1 was to place a quadro of small satellites into Earth orbit, but again failed when the first stage briefly recontacted the second stage engine nozzle after separation.",
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
            'summary' => "The fourth Falcon 1 became the first privately-developed liquid fueled rocket to reach orbit, carrying a boilerplate satellite.",
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
            'summary' => "The second successful flight, and final launch overall of Falcon 1 placed a Malaysian imaging satellite into orbit.",
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
            'summary' => "The first launch of the Falcon 9 and SpaceX's first flight from Cape Canaveral delivered the Dragon Spacecraft Qualification Unit into orbit.",
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
            'summary' => "The second launch of Falcon 9, and the Dragon spacecraft's first sojourn into Low Earth Orbit.",
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
            'summary' => "The first Falcon 9 night liftoff lifted into orbit the first ever private spacecraft to dock with the International Space Station.",
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
            'summary' => "The first of twelve contracted International Space Station resupply missions with Dragon, this mission unexpectedly demonstrated Falcon 9's engine-out capability.",
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
            'summary' => "Dragon's second flight under the CRS contract to the ISS, and the fifth and last flight of Falcon 9 v1.0.",
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
            'summary' => "SpaceX's first launch from Vandenberg delivered the CASSIOPE satellite into a polar orbit with a new payload fairing. Meanwhile, the first stage attempted a propulsive soft splashdown in the Pacific.",
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
            'summary' => "Second Falcon 9v1.1 launch, the first from Cape Canaveral. This flight's other firsts include achieving a GTO orbit, a Merlin 1D upper stage restart, and a communications satellite payload.",
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
            'summary' => "The third Falcon 9v1.1 launch and the 8th Falcon 9 launch overall, SpaceX delivered the communications satellite Thaicom 6 into a supersynchronous GTO orbit similar to that of SES-8.",
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
            'summary' => "The third Dragon CRS mission to the ISS was the first to fly on a Falcon 9v1.1, giving Dragon a larger cargo capacity.",
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
            'summary' => "A Falcon 9 flew the first 6 Orbcomm G2 satellites of a constellation into  Low Earth Orbit as part of a multi-mission contract for the communications corporation.",
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
            'summary' => "AsiaSat 8 was a communications satellite that Falcon 9 propelled into a GTO orbit, the largest satellite SpaceX had launched up to that point.",
            'article' => file_get_contents(base_path('resources/assets/documents/asiasat8.txt')),
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
            'summary' => "AsiaSat 6 is a communications satellite being launched for Asia Satellite Telecommunications Company Ltd. Once in orbit, it will be renamed AsiaSat 6 / Thaicom 7.",
            'article' => file_get_contents(base_path('resources/assets/documents/asiasat6.txt')),
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
            'summary' => "The fourth of twelve Dragon ISS resupply missions, CRS-4 carried over 5000 pounds in cargo to the station- including 20 mousetronauts, and the SpinSat satellite.",
            'article' => file_get_contents(base_path('resources/assets/documents/crs4.txt')),
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
            'article' => file_get_contents(base_path('resources/assets/documents/crs5.txt')),
            'summary' => "The fifth CRS mission to the ISS carried both pressurized and unpressurized cargo, including 2 small satellites that were deployed from the ISS airlock. This was also the first mission to attempt landing the first stage on a solid surace- the ASDS.",
            'status' => MissionStatus::Complete,
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
            'article' => file_get_contents(base_path('resources/assets/documents/dscovr.txt')),
            'summary' => "Falcon 9 lofted the much-delayed Deep Space Climate Observatory to Sun-Earth L1 for NOAA, where it functions as an Earth & Solar Observation satellite. The first stage was not able to attempt a barge landing, and instead softly splashed down in the Atlantic.",
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
            'article' => file_get_contents(base_path('resources/assets/documents/eutelsatabs.txt')),
            'summary' => "This marked SpaceX's first dual communications satellite launch, of Eutelsat 115W B & ABS-3A. The Boeing-built satellites use solar electric propulsion, which made it feasible to fit both on a single Falcon 9 because it removed the need for weighty hydrazine fuel.",
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
            'article' => file_get_contents(base_path('resources/assets/documents/crs6.txt')),
            'summary' => "The sixth of fifteen Dragon ISS resupply missions to the ISS was the second mission to attempt landing the first stage on the ASDS, just barely failing to stick the landing.",
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
            'article' => file_get_contents(base_path('resources/assets/documents/turkmensat.txt')),
            'summary' => "A Falcon 9 launched Turkmenistan's first communications satellite into GTO orbit in April 2015, following SpaceX's shortest turnaround time yet.",
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
            'article' => file_get_contents(base_path('resources/assets/documents/crs7.txt')),
            'summary' => "Falcon 9 lifted off carrying Dragon and an International Docking Adapter for the ISS, but an overpressure event caused the rocket to disintegrate moments before stage separation, marking Falcon 9's first launch failure ever and SpaceX's first since Falcon 1 Flight 3.",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Failure,
            'flight_club' => 'http://www.flightclub.io/results.php?id=ad8d5e76-ad6b-4670-9aee-60c1319dff50&code=CRS7'
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::ConstellationMission)->firstOrFail()->mission_type_id,
            'launch_order_id' => 25,
            'launch_exact' => Carbon::create(2015, 12, 22, 1, 33, 0),
            'launch_approximate' => null,
            'launch_specificity' => 6,
            'name' => 'Orbcomm OG2 Launch 2',
            'contractor' => 'Orbcomm',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'launch_illumination' => 'Night',
            'summary' => "SpaceX's Return To Flight Mission carried 11 satellites into Low Earth Orbit for communications company Orbcomm, while the first stage successfully returned to Landing Zone 1 at Cape Canaveral, making history as the first orbital-class rocket stage to land propulsively on land",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success,
        ]);

        // Upcoming below
        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::Scientific)->firstOrFail()->mission_type_id,
            'launch_order_id' => 26,
            'launch_exact' => Carbon::create(2016, 1, 17, 18, 42, 18),
            'launch_approximate' => null,
            'launch_specificity' => LaunchSpecificity::Precise,
            'name' => 'Jason 3',
            'contractor' => 'NASA',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::PolarOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-4E')->firstOrFail()->location_id,
            'summary' => "Launching Jason-3 to polar orbit is the second Falcon 9 flying out of Vandenberg Air Force base in California. This represents the last remaining F9v1.1 flight.",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 27,
            'launch_exact' => Carbon::create(2016, 1, 23, 0, 0, 0),
            'launch_approximate' => null,
            'launch_specificity' => LaunchSpecificity::Day,
            'name' => 'SES-9',
            'contractor' => 'SES',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::SubsynchronousGTO)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "SpaceX's second launch for SES, lofting a 5300kg communications satellite that will provide SES with more coverage over Southeast Asia.",
            'status' => MissionStatus::Upcoming
        ]);

        // Ordered above
        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 28,
            'launch_exact' => null,
            'launch_approximate' => 'February 2016',
            'launch_specificity' => LaunchSpecificity::Month,
            'name' => 'SpaceX CRS-8',
            'contractor' => 'NASA',
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbitISS)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "CRS-8 will be the first CRS mission to the ISS since the ill-fated CRS-7, and stowed in Dragon's trunk will be BEAM- a small Bigelow inflatable module to be attached to the station.",
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
            'summary' => "CRS-9 will be the ninth of fifteen missions to the ISS under the Commercial Resupply Services contract with NASA.",
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
            'summary' => "For SHERPA Flight 1, SpaceX will lift a plethora of smallsats into a polar orbit from Vandenberg.",
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
            'summary' => "The highly-anticipated debut of Falcon Heavy will carry an unknown payload within a standard payload fairing.",
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
            'summary' => "CRS-10 will be the tenth of fifteen missions to the ISS under the Commercial Resupply Services contract with NASA.",
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
            'summary' => "CRS-11 will be the eleventh of fifteen missions to the ISS under the Commercial Resupply Services contract with NASA.",
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
            'summary' => "SpaceX will launch AMOS-6, a 5 ton Israeli communications satellite that will replace its aging predecessor.",
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
            'summary' => "STP-2 will be the USAF's first misson using Falcon Heavy, and Falcon Heavy's second launch overall. It will carry a variety of experimental payloads to several different orbits.",
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
            'summary' => "SpaceX will loft the 5300kg SES-10 satellite into GTO for SES, which will use it to expand coverage for Latin America.",
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
            'summary' => "CRS-12 will be the twelfth of fifteen missions to the ISS under the Commercial Resupply Services contract with NASA.",
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
            'summary' => "SpaceX will launch the 5400kg communications satellite Echostar 105/SES-11 for Echostar and SES, providing coverage for North America.",
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
            'summary' => "CCtCap Demo Mission 1 will be SpaceX's first orbital mission with Crew Dragon, sending the unmanned vehicle to dock with the ISS for 30 days, reenter and then splashdown under parachutes in the ocean.",
            'status' => MissionStatus::Upcoming
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::CommunicationsSatellite)->firstOrFail()->mission_type_id,
            'launch_order_id' => 40,
            'launch_exact' => null,
            'launch_approximate' => 'Late 2016',
            'launch_specificity' => LaunchSpecificity::SubYear,
            'name' => "Es'hail 2",
            'contractor' => "Es'hailSat",
            'vehicle_id' => 4,
            'destination_id' => Destination::where('destination', DestinationEnum::GeostationaryTransferOrbit)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "SpaceX will launch a 3000kg communications satellite for Qatar-based company Es'hailSat.",
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
            'summary' => "SpaceX will launch a 5900kg telecommunications satellite for companies Inmarsat and Hellas-Sat, providing services for Europe.",
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
            'summary' => "SpaceX will launch the last of four 6070kg broadband satellites for Inmarsat.",
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
            'summary' => "SpaceX will launch an unspecified satellite for Intelsat.",
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
            'summary' => "SpaceX will carry up several of Iridium's next-generation communications satellites on the first flight of seven in a $492 million contract.",
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
            'summary' => "SpaceX will carry up several of Iridium's next-generation communications satellites on the second flight of seven in a $492 million contract.",
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
            'summary' => "SpaceX will carry up several of Iridium's next-generation communications satellites on the third flight of seven in a $492 million contract.",
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
            'summary' => "This will be SpaceX's second dual communications satellite launch, of Eutelsat 115W B & ABS-2A. The Boeing-built satellites will use solar electric propulsion for weight savings just like the previous Eutelsat/ABS dual launch.",
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
            'summary' => "SpaceX will launch a telecommunications satellite of unknown mass for Japanese satellite operator SKY Perfect JSAT, providing services for East Asia.",
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
            'summary' => "SpaceX will launch a radar-mapping satellite of unknown mass for the civilian arm of Argentina's space agency, the first of two.",
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
            'summary' => "SpaceX will launch a  telecommunications satellite of unknown mass for Bulgaria, providing increased services for the Balkan region of Europe.",
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
            'summary' => "SpaceX will launch a telecommunications satellite of unknown mass for Japanese satellite operator SKY Perfect JSAT. It will act as a backup transmitter for the rest of the company's satellite fleet.",
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
            'summary' => "SpaceX will launch a telecommunications satellite of unknown mass for South Korean communications company KT Corp. Built by Thales Alenia, KoreaSat-5A will be constructed using the largest 3-D printed spacecraft parts made in Europe.",
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
            'summary' => "SpaceX will launch a 3100kg communications satellite for Thai satellite operator Thaicom, providing increased services for Southeast Asia.",
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
            'summary' => "SpaceX will launch a broadband satellite  for American service provider ViaSat Inc.",
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
            'summary' => "SpaceX will launch the Transiting Exoplanet Survey Satellite (TESS) for NASA into an elliptical High Earth Orbit, where TESS will survey nearby stars for exoplanets.",
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
            'summary' => "SpaceX will launch a 4200kg telecommunications satellite using electric propulsion for satellite operator SES. Hitching a ride on the satellite will be GOLD, a NASA experiment that will observe the impact of solar weather on the atmosphere from geosynchronous orbit.",
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
            'summary' => "SpaceX will launch a broadband communications satellite of unknown mass for Spanish satellite operator HISPASAT, increasing coverage between Latin America and Europe.",
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
            'summary' => "SpaceX will launch the SpaceIL Lunar Lander to the vicinity of the moon for Israeli nonprofit SpaceIL, which seeks to win Google's Lunar X-Prize. The X-Prize will award $20 million to the first team to land a rover on the moon, drive 500 meters, and transmit back high-quality video.",
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
            'summary' => "SpaceX will demonstrate Crew Dragon's ability to abort while in flight, as opposed to on the launchpad. The test will use the same Dragon that will have flown on DM-1.",
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
            'summary' => "CRS-13 will be the thirteenth of fifteen missions to the ISS under the Commercial Resupply Services contract with NASA.",
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
            'summary' => "CRS-14 will be SpaceX's penultimate mission to the ISS under the Commercial Resupply Services contract with NASA.",
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
            'summary' => "CRS-15 will be the last of SpaceX's missions to the ISS under the Commercial Resupply Services contract with NASA, although ISS visits will continue as SpaceX does crew rotations under the Commercial Crew contract.",
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
            'summary' => "The two-week Demonstration Mission 2 will be SpaceX's second orbital flight using Dragon 2, and the first one with crew onboard.",
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
            'summary' => "SpaceX will carry up several of Iridium's next-generation communications satellites on the fourth flight of seven in a $492 million contract.",
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
            'summary' => "SpaceX will carry up several of Iridium's next-generation communications satellites on the fifth flight of seven in a $492 million contract.",
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
            'summary' => "SpaceX will carry up several of Iridium's next-generation communications satellites on the sixth flight of seven in a $492 million contract.",
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
            'summary' => "SpaceX will carry up several of Iridium's next-generation communications satellites on the last flight of seven in a $492 million contract.",
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
            'summary' => "SpaceX will loft a 5000kg  communications satellite into orbit for Indonesian satellite operator PSN, increasing coverage in Indonesia.",
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
            'summary' => "SpaceX will launch a radar-mapping satellite of unknown mass for the civilian arm of Argentina's space agency, the second of two.",
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
            'summary' => "SpaceX will launch three satellites of unknown mass for the Canadian government to form the Radarsat Constellation Mission, or RCM.",
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
            'summary' => "SpaceX will launch a communications satellite of unknown mass for Saudi satellite operator Arabsat.",
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
            'summary' => "SpaceX will launch a 2200kg radar-reconaissance satellite for the German armed forces.",
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
            'summary' => "SpaceX will launch two passive reflective 1800kg satellites to complete the SARah formation for the German armed forces.",
            'status' => MissionStatus::Upcoming
        ]);
    }
}