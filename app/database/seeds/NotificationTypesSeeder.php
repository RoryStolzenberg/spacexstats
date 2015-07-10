<?php
class NotificationTypesSeeder extends Seeder {
    public function run() {
        NotificationType::insert(array(
            array('name' => 'New Mission'),
            array('name' => 'Launch Time Change'),
            array('name' => 'T-24 Hours Email'),
            array('name' => 'T-3 Hours Email'),
            array('name' => 'T-1 Hour Email'),
            array('name' => 'News Summaries'),
            array('name' => 'T-24 Hours SMS'),
            array('name' => 'T-3 Hours SMS'),
            array('name' => 'T-1 Hour SMS')
        ));
    }
}