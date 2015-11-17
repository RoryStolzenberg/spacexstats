<?php
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Profile;

class ProfilesTableSeeder extends Seeder {
    public function run() {
        Profile::create(array(
            'user_id' => 1,
            'summary' => 'CEO and Chief Engineer of SpaceX & Tesla Motors. A literal god.',
            'twitter_account' => 'ElonMusk',
            'favorite_mission' => 1,
            'favorite_mission_patch' => 1
        ));

        Profile::create(array(
            'user_id' => 2,
            'summary' => 'VP of sales',
            'favorite_mission' => 4,
            'favorite_mission_patch' => 1
        ));

        Profile::create(array(
            'user_id' => 3,
            'summary' => 'Creator of the Merlin Engine',
            'twitter_account' => 'TMueller'
        ));

        Profile::create(array(
            'user_id' => 4,
            'summary' => 'DFJ',
            'twitter_account' => 'DFJ'
        ));

        Profile::create(array(
            'user_id' => 5,
            'summary' => 'Barry Matsomouri',
            'twitter_account' => 'Barry'
        ));
    }
}