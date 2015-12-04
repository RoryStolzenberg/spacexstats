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
            'display' => 'mission'
        ));

        // Launch Counts
        Statistic::create(array(
            'order' => 2,
            'type' => 'Launch Count',
            'name' => 'Total',
            'description' => 'SpaceX has launched {{ n }} vehicles in total',
            'unit' => json_encode('Flights'),
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 3,
            'type' => 'Launch Count',
            'name' => 'Falcon 9',
            'description' => 'Falcon 9 has launched {{n}} times',
            'unit' => json_encode('Flights'),
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 4,
            'type' => 'Launch Count',
            'name' => 'Falcon Heavy',
            'description' => 'Falcon Heavy has launched {{n}} times',
            'unit' => json_encode('Flights'),
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 5,
            'type' => 'Launch Count',
            'name' => 'Falcon 1',
            'description' => 'Falcon 1 has launched {{n}} times',
            'unit' => json_encode('Flights'),
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 6,
            'type' => 'Launch Count',
            'name' => 'MCT',
            'description' => "Mars Colonial Transporter hasn't launched yet :(",
            'unit' => json_encode('Flights'),
            'display' => 'single'
        ));

        // Launches per year
        Statistic::create(array(
            'order' => 7,
            'type' => 'Launches Per Year',
            'name' => 'Launches Per Year',
            'description' => "",
            'display' => 'graph'
        ));

        // Dragon
        Statistic::create(array(
            'order' => 8,
            'type' => 'Dragon',
            'name' => 'Missions',
            'description' => "Dragon has flown {{ n }} times.",
            'unit' => json_encode('Flights'),
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 9,
            'type' => 'Dragon',
            'name' => 'ISS Resupplies',
            'description' => "Dragon has flown {{ n }} times to the ISS.",
            'unit' => json_encode('Flights'),
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
            'unit' => json_encode(['Kilograms Up', 'Kilograms Down']),
            'display' => 'double'
        ));

        Statistic::create(array(
            'order' => 13,
            'type' => 'Dragon',
            'name' => 'Reflights',
            'description' => "",
            'unit' => json_encode('Reflights'),
            'display' => 'single'
        ));

        // Vehicles
        Statistic::create(array(
            'order' => 14,
            'type' => 'Vehicles',
            'name' => 'Landed',
            'description' => "",
            'unit' => json_encode('Landed'),
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 15,
            'type' => 'Vehicles',
            'name' => 'Reflown',
            'description' => "",
            'unit' => json_encode('Reflown'),
            'display' => 'single'
        ));

        // Engines
        Statistic::create(array(
            'order' => 16,
            'type' => 'Engines',
            'name' => 'Flown',
            'description' => "SpaceX have in total, launched {{ n }} engines from all their missions.",
            'unit' => json_encode('Flown'),
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
            'unit' => json_encode('Percent'),
            'display' => 'single'
        ));

        // Launch Sites
        Statistic::create(array(
            'order' => 19,
            'type' => 'Cape Canaveral',
            'name' => 'Launches',
            'description' => "Launches from Florida",
            'unit' => json_encode('Launches'),
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 20,
            'type' => 'Cape Kennedy',
            'name' => 'Launches',
            'description' => "Launches from Florida",
            'unit' => json_encode('Launches'),
            'display' => 'single'
        ));


        Statistic::create(array(
            'order' => 21,
            'type' => 'Vandenberg',
            'name' => 'Launches',
            'description' => "Launches from Vandenberg",
            'unit' => json_encode('Launches'),
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 22,
            'type' => 'Boca Chica',
            'name' => 'Launches',
            'description' => "Launches from Boca Chica",
            'unit' => json_encode('Launches'),
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 23,
            'type' => 'Kwajalein',
            'name' => 'Launches',
            'description' => "Launches from Kwajalein",
            'unit' => json_encode('Launches'),
            'display' => 'single'
        ));

        // DragonRiders
        Statistic::create(array(
            'order' => 24,
            'type' => 'DragonRiders',
            'name' => 'In Space',
            'description' => "",
            'unit' => json_encode('DragonRiders'),
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 25,
            'type' => 'DragonRiders',
            'name' => 'Cumulative',
            'description' => "",
            'unit' => json_encode('DragonRiders'),
            'display' => 'single'
        ));

        // Elon Musk's Mars bet expires
        Statistic::create(array(
            'order' => 26,
            'type' => "Elon Musk's Bet Expires",
            'name' => "Elon Musk's Bet Expires",
            'description' => '',
            'display' => 'count'
        ));

        // Payloads
        Statistic::create(array(
            'order' => 27,
            'type' => "Payloads",
            'name' => 'Satellites Launched',
            'description' => '',
            'unit' => json_encode(['Primary', 'Total']),
            'display' => 'double'
        ));

        Statistic::create(array(
            'order' => 28,
            'type' => "Payloads",
            'name' => 'Total Mass',
            'description' => '',
            'unit' => json_encode('Kilograms'),
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 29,
            'type' => "Payloads",
            'name' => 'Mass to GTO',
            'description' => '',
            'unit' => json_encode('Kilograms'),
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 30,
            'type' => "Payloads",
            'name' => 'Heaviest Satellite',
            'description' => '',
            'unit' => json_encode('Kilograms'),
            'display' => 'single'
        ));

        // Upper Stages
        Statistic::create(array(
            'order' => 31,
            'type' => "Upper Stages",
            'name' => 'In Orbit',
            'description' => '',
            'unit' => json_encode('Upper Stages'),
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 32,
            'type' => "Upper Stages",
            'name' => "TLEs",
            'description' => '',
            'unit' => json_encode('Two Line Elements'),
            'display' => 'single'
        ));

        // Distance
        Statistic::create(array(
            'order' => 33,
            'type' => "Distance",
            'name' => 'Earth Orbit',
            'description' => '',
            'unit' => json_encode('Kilometres'),
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 34,
            'type' => "Distance",
            'name' => 'Solar System',
            'description' => '',
            'unit' => json_encode('Kilometres'),
            'display' => 'single'
        ));

        // Turnaround time
        Statistic::create(array(
            'order' => 35,
            'type' => 'Turnarounds',
            'name' => 'Quickest',
            'description' => "SpaceX's quickest turnaround between two launches has been between {{ firstLaunch }} on {{ firstLaunchDate }}, and {{ secondLaunch }} on {{ secondLaunchDate }}",
            'display' => 'interval'
        ));

        Statistic::create(array(
            'order' => 36,
            'type' => 'Turnarounds',
            'name' => 'Since Last Launch',
            'description' => "",
            'display' => 'count'
        ));

        Statistic::create(array(
            'order' => 37,
            'type' => 'Turnarounds',
            'name' => 'Cumulative',
            'description' => "",
            'display' => 'graph'
        ));

        // Internet Constellaiton
        Statistic::create(array(
            'order' => 38,
            'type' => 'Internet Constellation',
            'name' => 'Internet Constellation',
            'description' => "",
            "unit" => json_encode('Total Launched'), // 0/4025
            'display' => 'single'
        ));

        // Mars Population Count
        Statistic::create(array(
            'order' => 39,
            'type' => 'Mars Population Count',
            'name' => 'Mars Population Count',
            'description' => "",
            "unit" => json_encode('People'),
            'display' => 'single'
        ));

        // Hours worked
        Statistic::create(array(
            'order' => 40,
            'type' => 'Hours Worked',
            'name' => 'Hours Worked',
            'description' => "",
            'display' => 'gesture'
        ));
    }
}