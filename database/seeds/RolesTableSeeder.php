<?php
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Role;

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