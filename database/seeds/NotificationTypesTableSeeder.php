<?php
use Illuminate\Database\Seeder;
use SpaceXStats\Models\NotificationType;

class NotificationTypesTableSeeder extends Seeder {
    public function run() {
        NotificationType::insert(array(
            array('name' => 'newMission'),
            array('name' => 'LaunchChange'),
            array('name' => 'TMinus24HoursEmail'),
            array('name' => 'TMinus3HoursEmail'),
            array('name' => 'TMinus1HourEmail'),
            array('name' => 'NewsSummaries'),
            array('name' => 'TMinus24HoursSMS'),
            array('name' => 'TMinus3HoursSMS'),
            array('name' => 'TMinus1HourSMS')
        ));
    }
}