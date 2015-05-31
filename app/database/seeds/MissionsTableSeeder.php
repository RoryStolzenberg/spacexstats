<?php
use Carbon\Carbon;

class MissionsTableSeeder extends Seeder {
    public function run() {
        Mission::create(array(
            'launch_order_id' => 1,
            'launch_exact' => Carbon::now()->subMonth(),
            'name' => 'DSQU',
            'contractor' => 'SpaceX',
            'vehicle_id' => 2,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => LaunchSite::where('name', 'SLC-40')->firstOrFail()->launch_site_id,
            'article' => "Here's an article",
            'featured_image' => 1,
            'status' => 'Complete'
        ));

        Mission::create(array(
            'launch_order_id' => 2,
            'launch_exact' => Carbon::now()->subWeek(),
            'name' => 'COTS-1',
            'contractor' => 'SpaceX',
            'vehicle_id' => 2,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => LaunchSite::where('name', 'SLC-40')->firstOrFail()->launch_site_id,
            'article' => "Here's an article",
            'status' => 'Complete'
        ));

        Mission::create(array(
            'launch_order_id' => 3,
            'launch_exact' => Carbon::now()->subDay(),
            'name' => 'COTS-2+',
            'contractor' => 'SpaceX',
            'vehicle_id' => 2,
            'destination_id' => Destination::where('destination', 'Low Earth Orbit')->firstOrFail()->destination_id,
            'launch_site_id' => LaunchSite::where('name', 'SLC-40')->firstOrFail()->launch_site_id,
            'article' => "Here's an article",
            'status' => 'Complete'
        ));
    }
}