<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use SpaceXStats\Models\User;

class UsersTableSeeder extends Seeder {
    public function run() {
        User::create(array(
            'role_id' => 6,
            'username' => 'elonmusk',
            'email' => 'elonmusk@spacexstats.com',
            'password' => 'password',
            'subscription_expires_at' => Carbon::now()->addYear(),
            'key' => str_random(32)
        ));

        User::create(array(
            'role_id' => 6,
            'username' => 'gwynne',
            'email' => 'gwynne.shotwell@spacexstats.com',
            'password' => 'password',
            'subscription_expires_at' => Carbon::now()->addYear(),
            'key' => str_random(32)
        ));

        User::create(array(
            'role_id' => 2,
            'username' => 'TomMueller',
            'email' => 'tmueller@spacexstats.com',
            'password' => 'password',
            'subscription_expires_at' => Carbon::now()->addYear(),
            'key' => str_random(32)
        ));
    }
}