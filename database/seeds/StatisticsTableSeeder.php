<?php
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Statistic;

class StatisticsTableSeeder extends Seeder {
    public function run() {

        // Next launch
        Statistic::create(array(
            'order' => 1,
            'type' => 'Next Launch',
            'name' => 'Next Launch',
            'description' => '{{ nextLaunchSummary }}',
            'display' => 'count'
        ));

        // Launch Counts
        Statistic::create(array(
            'order' => 2,
            'type' => 'Launch Count',
            'name' => 'Total',
            'description' => 'SpaceX has launched {{ n }} vehicles in total',
            'unit' => 'Flights',
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 3,
            'type' => 'Launch Count',
            'name' => 'Falcon 9',
            'description' => 'Falcon 9 has launched {{n}} times',
            'unit' => 'Flights',
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 4,
            'type' => 'Launch Count',
            'name' => 'Falcon Heavy',
            'description' => 'Falcon Heavy has launched {{n}} times',
            'unit' => 'Flights',
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 5,
            'type' => 'Launch Count',
            'name' => 'Falcon 1',
            'description' => 'Falcon 1 has launched {{n}} times',
            'unit' => 'Flights',
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 6,
            'type' => 'Launch Count',
            'name' => 'MCT',
            'description' => "Mars Colonial Transporter hasn't launched yet :(",
            'unit' => 'Flights',
            'display' => 'single'
        ));

        // Launches per year
        Statistic::create(array(
            'order' => 7,
            'type' => 'Launches Per Year',
            'description' => "",
            'display' => 'graph'
        ));

        // Dragon
        Statistic::create(array(
            'order' => 8,
            'type' => 'Dragon',
            'name' => 'Missions',
            'description' => "Dragon has flown {{ n }} times.",
            'unit' => 'Flights',
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 9,
            'type' => 'Dragon',
            'name' => 'ISS Resupplies',
            'description' => "Dragon has flown {{ n }} times to the ISS.",
            'unit' => 'Flights',
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 10,
            'type' => 'Dragon',
            'name' => 'Total Flight Time',
            'description' => "Dragon has launched on ever increasing lengths of time.",
            'display' => 'interval'
        ));

        Statistic::create(array(
            'order' => 11,
            'type' => 'Dragon',
            'name' => 'Flight Time',
            'description' => "Dragon has launched on ever increasing lengths of time.",
            'display' => 'graph'
        ));

        Statistic::create(array(
            'order' => 12,
            'type' => 'Dragon',
            'name' => 'Cargo',
            'description' => "Dragon remains the only spacecraft in service capable of returning large quantities of cargo from the Station to Earth.",
            'unit' => "['kg Up', 'kg Down']",
            'display' => 'double'
        ));

        Statistic::create(array(
            'order' => 13,
            'type' => 'Dragon',
            'name' => 'Reused',
            'description' => "",
            'unit' => "Reused",
            'display' => 'single'
        ));

        // Vehicles
        Statistic::create(array(
            'order' => 14,
            'type' => 'Vehicles',
            'name' => 'Landed',
            'description' => "",
            'unit' => "Landed",
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 15,
            'type' => 'Vehicles',
            'name' => 'Reflown',
            'description' => "",
            'unit' => "Reflown",
            'display' => 'single'
        ));

        // Engines
        Statistic::create(array(
            'order' => 16,
            'type' => 'Engines',
            'name' => 'Flown',
            'description' => "SpaceX have in total, launched {{ n }} engines from all their missions.",
            'unit' => "Flown",
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 17,
            'type' => 'Engines',
            'name' => 'M1D Flight Time',
            'description' => "Merlin 1D is the 4th iteration of SpaceX's Merlin engine family. Using a mixture of RP-1 (Kerosene) and Liquid Oxygen (LOX), it achieves a thrust to weight ratio exceeding 150, the highest of any kerolox engine.",
            'display' => 'interval'
        ));

        Statistic::create(array(
            'order' => 18,
            'type' => 'Engines',
            'name' => 'M1D Success Rate',
            'description' => "100%",
            'unit' => 'Percent',
            'display' => 'single'
        ));

        // Launch Sites
        Statistic::create(array(
            'order' => 19,
            'type' => 'Cape Canaveral',
            'name' => 'Launches',
            'description' => "Launches from Florida",
            'unit' => "Launches",
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 20,
            'type' => 'Cape Kennedy',
            'name' => 'Launches',
            'description' => "Launches from Florida",
            'unit' => "Launches",
            'display' => 'single'
        ));


        Statistic::create(array(
            'order' => 21,
            'type' => 'Vandenberg',
            'name' => 'Launches',
            'description' => "Launches from Vandenberg",
            'unit' => "Launches",
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 22,
            'type' => 'Boca Chica',
            'name' => 'Launches',
            'description' => "Launches from Boca Chica",
            'unit' => "Launches",
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 23,
            'type' => 'Kwajalein',
            'name' => 'Launches',
            'description' => "Launches from Kwajalein",
            'unit' => "Launches",
            'display' => 'single'
        ));

        // DragonRiders
        Statistic::create(array(
            'order' => 24,
            'type' => 'DragonRiders',
            'name' => 'In Space',
            'description' => "",
            'unit' => 'DragonRiders',
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 25,
            'type' => 'DragonRiders',
            'name' => 'Cumulative',
            'description' => "",
            'unit' => 'DragonRiders',
            'display' => 'single'
        ));

        // Elon Musk's Mars bet expires
        Statistic::create(array(
            'order' => 26,
            'type' => "Elon Musk's Bet Expires",
            'name' => 'Cumulative',
            'description' => '',
            'display' => 'count'
        ));

        // Payloads
        Statistic::create(array(
            'order' => 27,
            'type' => "Payloads",
            'name' => 'Satellites Launched',
            'description' => '',
            'unit' => '["Primary", "Total"]',
            'display' => 'double'
        ));

        Statistic::create(array(
            'order' => 28,
            'type' => "Payloads",
            'name' => 'Total Mass',
            'description' => '',
            'unit' => 'KG',
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 29,
            'type' => "Payloads",
            'name' => 'Mass to GTO',
            'description' => '',
            'unit' => 'KG',
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 30,
            'type' => "Payloads",
            'name' => 'Heaviest Satellite',
            'description' => '',
            'unit' => 'KG',
            'display' => 'single'
        ));

        // Upper Stages
        Statistic::create(array(
            'order' => 31,
            'type' => "Upper Stages In Orbit",
            'description' => '',
            'unit' => 'upper stages',
            'display' => 'single'
        ));

        // Distance
        Statistic::create(array(
            'order' => 32,
            'type' => "Distance",
            'name' => 'Earth Orbit',
            'description' => '',
            'unit' => 'KM',
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 33,
            'type' => "Distance",
            'name' => 'Solar System',
            'description' => '',
            'unit' => 'KM',
            'display' => 'single'
        ));

        // Turnaround time
        Statistic::create(array(
            'order' => 34,
            'type' => 'Turnarounds',
            'name' => 'Quickest',
            'description' => "SpaceX's quickest turnaround between two launches has been between {{ firstLaunch }} on {{ firstLaunchDate }}, and {{ secondLaunch }} on {{ secondLaunchDate }}",
            'display' => 'interval'
        ));

        Statistic::create(array(
            'order' => 35,
            'type' => 'Turnarounds',
            'name' => 'Since Last Launch',
            'description' => "",
            'display' => 'count'
        ));

        Statistic::create(array(
            'order' => 36,
            'type' => 'Turnarounds',
            'name' => 'Cumulative',
            'description' => "",
            'display' => 'graph'
        ));

        // Internet Constellaiton
        Statistic::create(array(
            'order' => 37,
            'type' => 'Internet Constellation',
            'description' => "",
            "unit" => "Total Launched", // 0/4025
            'display' => 'single'
        ));

        // Mars Population Count
        Statistic::create(array(
            'order' => 38,
            'type' => 'Mars Population Count',
            'description' => "",
            "unit" => "People",
            'display' => 'single'
        ));

        // Hours worked
        Statistic::create(array(
            'order' => 39,
            'type' => 'Hours Worked',
            'description' => "",
            'display' => 'gesture'
        ));
    }
}