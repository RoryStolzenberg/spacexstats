<?php
class ProfilesTableSeeder extends Seeder {
    public function run() {
        Profile::create(array(
            'user_id' => 1,
            'summary' => 'CEO and Chief Engineer of SpaceX & Tesla Motors. A literal god.',
            'twitter_account' => 'ElonMusk'
        ));
    }
}