<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('RolesTableSeeder');
        $this->call('DestinationsTableSeeder');
        $this->call('LaunchSitesTableSeeder');
        $this->call('LandingSitesTableSeeder');
        $this->call('VehiclesTableSeeder');
        $this->call('UsersTableSeeder');
        $this->call('ProfilesTableSeeder');
        $this->call('StatisticsTableSeeder');
        $this->call('ObjectsTableSeeder');
        $this->call('CoresTableSeeder');
        $this->call('MissionsTableSeeder');
        $this->call('UsesTableSeeder');
	}

}
