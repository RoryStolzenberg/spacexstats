<?php
use Carbon\Carbon;

class MissionsTableSeeder extends Seeder {
    public function run() {
        Mission::create(array(
            'launch_order_id' => 1,
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
            'status' => 'Complete'
        ));

        Mission::create(array(
            'launch_order_id' => 2,
            'launch_exact' => Carbon::now()->subWeek(),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'COTS-1',
            'contractor' => 'SpaceX',
            'vehicle_id' => 2,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'article' => "Here's an article",
            'status' => 'Complete'
        ));

        Mission::create(array(
            'launch_order_id' => 3,
            'launch_exact' => Carbon::now()->subDay(),
            'launch_approximate' => null,
            'launch_specificity' => 7,
            'name' => 'COTS-2+',
            'contractor' => 'SpaceX',
            'vehicle_id' => 2,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => Location::where('name', 'SLC-40')->firstOrFail()->location_id,
            'article' => "Here's an article",
            'status' => 'Complete'
        ));

        Mission::create(array(
            'launch_order_id' => 4,
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
    }
}