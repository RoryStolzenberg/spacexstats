<?php
class SubscriptionTypesSeeder extends Seeder {
    public function run() {
        SubscriptionType::insert(array(
            array('name' => 'New Mission'),
            array('name' => 'Launch Time Change'),
            array('name' => 'T-24 Hours'),
            array('name' => 'T-3 Hours'),
            array('name' => 'T-1 Hour'),
            array('name' => 'News Summaries')
        ));
    }
}