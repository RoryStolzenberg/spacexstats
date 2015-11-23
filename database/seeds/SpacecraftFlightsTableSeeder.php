<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use SpaceXStats\Models\SpacecraftFlight;

class SpacecraftFlightsTableSeeder extends Seeder {
    public function run() {
        // COTS-1
        SpacecraftFlight::create([
            'mission_id' => 8,
            'spacecraft_id' => 1,
            'flight_name' => 'COTS Demo 1',
            'return_method' => 'Splashdown',
            'end_of_mission' => Carbon::create(2010, 12, 8, 19, 2, 52)
        ]);

        // COTS-2+
        SpacecraftFlight::create([
            'mission_id' => 8,
            'spacecraft_id' => 2,
            'flight_name' => 'COTS Demo 2+',
            'return_method' => 'Splashdown',
            'upmass' => 520,
            'downmass' => 660,
            'end_of_mission' => Carbon::create(2012, 5, 31, 15, 42, 0),
            'iss_berth' => Carbon::create(2012, 5, 25, 16, 2, 0),
            'iss_unberth' => Carbon::create(2012, 5, 31, 9, 49, 0),
        ]);

        // CRS-1
        SpacecraftFlight::create([
            'mission_id' => 9,
            'spacecraft_id' => 3,
            'flight_name' => 'SpaceX CRS-1',
            'return_method' => 'Splashdown',
            'upmass' => 905,
            'downmass' => 905,
            'end_of_mission' => Carbon::create(2012, 10, 28, 19, 22, 0),
            'iss_berth' => Carbon::create(2012, 10, 10, 13, 3, 0),
            'iss_unberth' => Carbon::create(2012, 10, 28, 13, 29, 0),
        ]);

        // CRS-2
        SpacecraftFlight::create([
            'mission_id' => 10,
            'spacecraft_id' => 4,
            'flight_name' => 'SpaceX CRS-2',
            'return_method' => 'Splashdown',
            'upmass' => 677,
            'downmass' => 1370,
            'end_of_mission' => Carbon::create(2013, 3, 26, 16, 34, 0),
            'iss_berth' => Carbon::create(2013, 3, 3, 13, 56, 0),
            'iss_unberth' => Carbon::create(2013, 3, 26, 8, 10, 0),
        ]);

        // CRS-3
        SpacecraftFlight::create([
            'mission_id' => 14,
            'spacecraft_id' => 5,
            'flight_name' => 'SpaceX CRS-3',
            'return_method' => 'Splashdown',
            'upmass' => 2117,
            'downmass' => 1563,
            'end_of_mission' => Carbon::create(2014, 5, 18, 19, 5, 0),
            'iss_berth' => Carbon::create(2014, 4, 20, 14, 6, 0),
            'iss_unberth' => Carbon::create(2014, 5, 18, 11, 55, 0),
        ]);

        // CRS-4
        SpacecraftFlight::create([
            'mission_id' => 18,
            'spacecraft_id' => 6,
            'flight_name' => 'SpaceX CRS-4',
            'return_method' => 'Splashdown',
            'upmass' => 2216,
            'downmass' => 1486,
            'end_of_mission' => Carbon::create(2014, 10, 25, 19, 38, 0),
            'iss_berth' => Carbon::create(2014, 9, 23, 13, 21, 0),
            'iss_unberth' => Carbon::create(2014, 10, 25, 13, 57, 0),
        ]);

        // CRS-5
        SpacecraftFlight::create([
            'mission_id' => 19,
            'spacecraft_id' => 7,
            'flight_name' => 'SpaceX CRS-5',
            'return_method' => 'Splashdown',
            'upmass' => 2395,
            'downmass' => 1662,
            'end_of_mission' => Carbon::create(2015, 2, 11, 0, 44, 0),
            'iss_berth' => Carbon::create(2015, 1, 12, 13, 54, 0),
            'iss_unberth' => Carbon::create(2015, 2, 10, 17, 11, 0),
        ]);

        // CRS-6
        SpacecraftFlight::create([
            'mission_id' => 22,
            'spacecraft_id' => 8,
            'flight_name' => 'SpaceX CRS-6',
            'return_method' => 'Splashdown',
            'upmass' => 2015,
            'downmass' => 1370,
            'end_of_mission' => Carbon::create(2015, 5, 21, 16, 42, 0),
            'iss_berth' => Carbon::create(2015, 4, 17, 13, 29, 0),
            'iss_unberth' => Carbon::create(2015, 5, 21, 9, 29, 0),
        ]);

        // CRS-7
        SpacecraftFlight::create([
            'mission_id' => 24,
            'spacecraft_id' => 9,
            'flight_name' => 'SpaceX CRS-7',
            'return_method' => 'Did not return',
            'upmass' => 1952,
            'downmass' => 675,
            'end_of_mission' => Carbon::create(2015, 6, 28, 14, 21, 11)
        ]);
    }
}