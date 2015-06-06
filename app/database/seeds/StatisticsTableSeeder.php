<?php
class StatisticsTableSeeder extends Seeder {
    public function run() {
        Statistic::create(array(
            'order' => 1,
            'type' => 'Next Launch',
            'name' => 'Next Launch',
            'description' => '{{ nextLaunchSummary }}',
            'display' => 'count'
        ));

        Statistic::create(array(
            'order' => 2,
            'type' => 'Launch Count',
            'name' => 'Falcon 9',
            'description' => 'Falcon 9 has launched {{n}} times',
            'display' => 'single'
        ));

        Statistic::create(array(
            'order' => 3,
            'type' => 'Launch Count',
            'name' => 'Falcon Heavy',
            'description' => 'Falcon Heavy has launched {{n}} times',
            'display' => 'single'
        ));
    }
}