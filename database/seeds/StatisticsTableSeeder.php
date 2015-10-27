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

        // Dragon
        Statistic::create(array(
            'order' => 6,
            'type' => 'Dragon',
            'name' => 'Missions',
            'description' => "Dragon has flown {{ n }} times.",
            'unit' => 'Flights',
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 7,
            'type' => 'Dragon',
            'name' => 'ISS Resupplies',
            'description' => "Dragon has flown {{ n }} times to the ISS.",
            'unit' => 'Flights',
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 8,
            'type' => 'Dragon',
            'name' => 'Flight Time',
            'description' => "Dragon has launched on ever increasing lengths of time.",
            'display' => 'interval'
        ));

        Statistic::create(array(
            'order' => 9,
            'type' => 'Dragon',
            'name' => 'Cargo',
            'description' => "Dragon remains the only spacecraft in service capable of returning large quantities of cargo from the Station to Earth.",
            'unit' => "['kg Up', 'kg Down']"
            'display' => 'double'
        ));

        // Dragons - reused

        // Launch Sites
        Statistic::create(array(
            'order' => 10,
            'type' => 'Florida',
            'name' => 'Launches',
            'description' => "Launches from Florida",
            'unit' => "Launches"
            'display' => 'single'
        ));

        // Engines
        Statistic::create(array(
            'order' => 10,
            'type' => 'Engines',
            'name' => 'Flown',
            'description' => "SpaceX have in total, launched {{ n }} engines from all their missions.",
            'unit' => "Flown"
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 10,
            'type' => 'Engines',
            'name' => 'M1D Operating Time',
            'description' => "Merlin 1D is the 4th iteration of SpaceX's Merlin engine family. Using a mixture of RP-1 (Kerosene) and Liquid Oxygen (LOX), it achieves a thrust to weight ratio exceeding 150, the highest of any kerolox engine.",
            'display' => 'interval'
        ));

        Statistic::create(array(
            'order' => 10,
            'type' => 'Engines',
            'name' => 'M1D Success Rate',
            'description' => "100%",
            'unit' => 'Percent',
            'display' => 'single'
        ));

        // Astronauts
        Statistic::create(array(
            'order' => 10,
            'type' => 'Astronauts',
            'name' => 'In Space',
            'description' => "",
            'unit' => 'DragonRiders',
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 10,
            'type' => 'Astronauts',
            'name' => 'Cumulative',
            'description' => "",
            'unit' => 'DragonRiders',
            'display' => 'single'
        ));

        // Elon Musk's Mars bet expires

        // Satellites

        // Farthest distance from Earth

        // Turnaround time
        Statistic::create(array(
            'order' => 10,
            'type' => 'Quickest Turnaround',
            'name' => 'Quickest Turnaround',
            'description' => "SpaceX's quickest turnaround between two launches has been between {{ firstLaunch }} on {{ firstLaunchDate }}, and {{ secondLaunch }} on {{ secondLaunchDate }}",
            'display' => 'interval'
        ));

        // Mars Population Count

        // Vehicles - Landed
        // Vehicles - Reflown

        // Hours worked
        // Countless
    }
}