<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use SpaceXStats\Models\SpacecraftFlight;

class SpacecraftFlightsTableSeeder extends Seeder {
    public function run() {
        // COTS-2+
        SpacecraftFlight::create([
            'mission_id' => 8,
            'spacecraft_id' => 2,
            'flight_name' => 'COTS-2+',
            'return_method' => 'Splashdown',
            'upmass' => 520,
            'downmass' => 660,
            'end_of_mission' => Carbon::create(2012, 5, 31, 15, 42, 0),
            'iss_berth' => Carbon::create(2012, 5, 25, 16, 2, 0),
            'iss_unberth' => Carbon::create(2012, 5, 31, 9, 49, 0),
        ]);
    }
}