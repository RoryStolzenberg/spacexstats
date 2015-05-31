<?php
/**
 * Created by PhpStorm.
 * User: Luke
 * Date: 16/05/2015
 * Time: 9:23 AM
 */

class RolesTableSeeder extends Seeder {
    public function run() {
        Role::create(array('name' => 'Unauthenticated'));
        Role::create(array('name' => 'Member'));
        Role::create(array('name' => 'Subscriber'));
        Role::create(array('name' => 'Charter Subscriber'));
        Role::create(array('name' => 'Moderator'));
        Role::create(array('name' => 'Administrator'));
    }
}