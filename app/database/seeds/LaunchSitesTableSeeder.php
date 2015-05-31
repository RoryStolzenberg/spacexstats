<?php
/**
 * Created by PhpStorm.
 * User: Luke
 * Date: 17/05/2015
 * Time: 9:37 AM
 */

class LaunchSitesTableSeeder extends Seeder {
    public function run() {
        LaunchSite::create(array(
            'name' => 'Omelek Island',
            'location' => 'Kwajalein',
            'state' => 'Marshall Islands'
        ));

        LaunchSite::create(array(
            'name' => 'SLC-40',
            'location' => 'Cape Canaveral',
            'state' => 'Florida'
        ));

        LaunchSite::create(array(
            'name' => 'SLC-4E',
            'location' => 'Vandenberg',
            'state' => 'California'
        ));

        LaunchSite::create(array(
            'name' => 'LC-39A',
            'location' => 'Cape Kennedy',
            'state' => 'Florida'
        ));

        LaunchSite::create(array(
            'name' => 'Boca Chica',
            'location' => 'Brownsville',
            'state' => 'Texas'
        ));
    }
}