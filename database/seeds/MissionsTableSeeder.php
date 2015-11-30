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
            'launch_illumination' => 'Day',
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
            'launch_illumination' => 'Day',
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
            'launch_illumination' => 'Day',
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
            'name' => 'RazakSAT',
            'contractor' => 'SpaceX',
            'vehicle_id' => 1,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'Omelek Island')->firstOrFail()->location_id,
            'launch_illumination' => 'Day',
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
            'launch_illumination' => 'Day',
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
            'launch_illumination' => 'Day',
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
            'launch_illumination' => 'Night',
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
            'launch_illumination' => 'Day',
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
            'launch_illumination' => 'Day',
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
            'launch_illumination' => 'Day',
            'summary' => 'First Falcon 9v1.1 launch from Vandenberg delivering CASSIOPE satellite into a polar orbit with a new payload fairing. Attempt at propulsive over-water soft landing.',
            'article' => "Here's an article",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
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
            'article' => "default article",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
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
            'article' => "default summary",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
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
            'article' => "default summary",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
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
            'article' => "default summary",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
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
            'article' => "default summary",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
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
            'article' => "default summary",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
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
            'article' => "default summary",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
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
            'summary' => 'The fifth CRS mission to the ISS will carry pressurized and unpressurized cargo to the station. Secondary payloads include 2 small satellites to be deployed from the ISS airlock.',
            'article' => "default summary",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
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
            'article' => "default summary",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
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
            'article' => "default summary",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
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
            'article' => "default summary",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
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
            'article' => "default summary",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
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
            'article' => "default summary",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Failure
        ]);

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::ConstellationMission)->firstOrFail()->mission_type_id,
            'launch_order_id' => 25,
            'launch_exact' => Carbon::create(2015, 12, 11, 0, 0, 0),
            'launch_approximate' => null,
            'launch_specificity' => 6,
            'name' => 'Orbcomm OG2 Launch 2',
            'contractor' => 'Orbcomm',
            'vehicle_id' => 3,
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
            'vehicle_id' => 3,
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

        Mission::create([
            'mission_type_id' => MissionType::where('name', MissionTypeEnum::DragonISS)->firstOrFail()->mission_type_id,
            'launch_order_id' => 28,
            'launch_exact' => null,
            'launch_approximate' => 'January 2016',
            'launch_specificity' => LaunchSpecificity::Month,
            'name' => 'CRS-8',
            'contractor' => 'NASA',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', DestinationEnum::LowEarthOrbitISS)->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => "8th mission to the ISS",
            'status' => MissionStatus::Upcoming
        ]);
    }
}