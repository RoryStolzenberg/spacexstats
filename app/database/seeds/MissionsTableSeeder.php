<?php
use Carbon\Carbon;

class MissionsTableSeeder extends Seeder {
    public function run() {
        Mission::create(array(
            'mission_type_id' => 6,
            'launch_order_id' => 1,
            'launch_exact' => Carbon::now()->subYear(),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'FalconSAT-2',
            'contractor' => 'SpaceX',
            'vehicle_id' => 1,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'Omelek Island')->firstOrFail()->location_id,
            'summary' => "Here's a short summary of the mission",
            'article' => "Here's an article",
            'featured_image' => 1,
            'status' => 'Complete',
            'outcome' => 'Failure'
        ));


        Mission::create(array(
            'mission_type_id' => 7,
            'launch_order_id' => 2,
            'launch_exact' => Carbon::now()->subMonth(),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'DSQU',
            'contractor' => 'SpaceX',
            'vehicle_id' => 2,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'article' => "Here's an article",
            'featured_image' => 1,
            'status' => 'Complete',
            'outcome' => 'Success'
        ));

        Mission::create(array(
            'mission_type_id' => 2,
            'launch_order_id' => 3,
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
            'launch_order_id' => 4,
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
            'launch_order_id' => 5,
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
            'launch_order_id' => 6,
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