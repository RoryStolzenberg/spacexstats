<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Destination;
use SpaceXStats\Models\Location;
use SpaceXStats\Models\Mission;
use SpaceXStats\Library\Enums\MissionOutcome;
use SpaceXStats\Library\Enums\MissionStatus;

class MissionsTableSeeder extends Seeder {
    public function run() {
        Mission::create([
            'mission_type_id' => 7,
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
            'mission_type_id' => 7,
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
            'mission_type_id' => 7,
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
            'mission_type_id' => 7,
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
            'mission_type_id' => 7,
            'launch_order_id' => 5,
            'launch_exact' => Carbon::create(2009, 7, 14, 3, 35, 0),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'RAZAKSat',
            'contractor' => 'SpaceX',
            'vehicle_id' => 1,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'Omelek Island')->firstOrFail()->location_id,
            'summary' => "Final launch of Falcon 1 and SpaceX's second successful flight and first satellite in orbit. ",
            'article' => "Here's an article",
            'status' => MissionStatus::Complete,
            'outcome' => MissionOutcome::Success
        ]);

        Mission::create(array(
            'mission_type_id' => 7,
            'launch_order_id' => 6,
            'launch_exact' => Carbon::now()->subMonth(),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'DSQU',
            'contractor' => 'SpaceX',
            'vehicle_id' => 2,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'article' => "Here's an article",
            'status' => 'Complete',
            'outcome' => 'Success'
        ));

        Mission::create(array(
            'mission_type_id' => 2,
            'launch_order_id' => 7,
            'launch_exact' => Carbon::now()->subWeek(),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'COTS-1',
            'contractor' => 'SpaceX',
            'vehicle_id' => 2,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'article' => "Here's an article",
            'status' => 'Complete',
            'outcome' => 'Success'
        ));

        Mission::create(array(
            'mission_type_id' => 1,
            'launch_order_id' => 8,
            'launch_exact' => Carbon::now()->subDay(),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'COTS-2+',
            'contractor' => 'SpaceX',
            'vehicle_id' => 2,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'article' => "Here's an article",
            'status' => 'Complete',
            'outcome' => 'Success'
        ));

        Mission::create(array(
            'mission_type_id' => 1,
            'launch_order_id' => 9,
            'launch_exact' => Carbon::now()->addWeek(),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'CRS-1',
            'contractor' => 'NASA',
            'vehicle_id' => 2,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'summary' => 'Here is a summary of the next mission, courtesy me',
            'article' => "Here's an article",
            'status' => 'Upcoming'
        ));

        Mission::create(array(
            'mission_type_id' => 9,
            'launch_order_id' => 10,
            'launch_exact' => Carbon::now()->addMonth(),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'CASSIOPE',
            'contractor' => 'MDA Corp.',
            'vehicle_id' => 3,
            'destination_id' => Destination::where('destination', 'Polar Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-4E')->firstOrFail()->location_id,
            'summary' => 'Here is a summary of the next mission, courtesy me',
            'article' => "Here's an article",
            'status' => 'Upcoming'
        ));
    }
}