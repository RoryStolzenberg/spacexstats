<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use SpaceXStats\Models\User;
use SpaceXStats\Library\Enums\UserRole;

class UsersTableSeeder extends Seeder {
    public function run() {
        User::create(array(
            'role_id' => UserRole::Administrator,
            'username' => 'elonmusk',
            'email' => 'elonmusk@spacexstats.com',
            'password' => 'password',
            'key' => str_random(32),
            'launch_controller_flag' => true
        ));

        User::create(array(
            'role_id' => UserRole::CharterSubscriber,
            'username' => 'gwynne.shotwell',
            'email' => 'gwynne.shotwell@spacexstats.com',
            'password' => 'password',
            'key' => str_random(32)
        ));

        User::create(array(
            'role_id' => UserRole::Subscriber,
            'username' => 'TomMueller',
            'email' => 'tmueller@spacexstats.com',
            'password' => 'password',
            'subscription_ends_at' => Carbon::now()->addYear(),
            'key' => str_random(32)
        ));

        User::create(array(
            'role_id' => UserRole::Member,
            'username' => 'stevejurvetson',
            'email' => 'dfj@spacexstats.com',
            'password' => 'password',
            'key' => str_random(32)
        ));

        User::create(array(
            'role_id' => UserRole::Unauthenticated,
            'username' => 'barrymatsomuri',
            'email' => 'barrymatsomuri@spacexstats.com',
            'password' => 'password',
            'key' => str_random(32)
        ));
    }
}