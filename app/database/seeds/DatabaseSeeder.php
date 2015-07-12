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

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

		$this->call('RolesTableSeeder');
        $this->call('DestinationsTableSeeder');
        $this->call('LocationsTableSeeder');
        $this->call('VehiclesTableSeeder');
        $this->call('UsersTableSeeder');
        $this->call('ProfilesTableSeeder');
        $this->call('StatisticsTableSeeder');
        $this->call('ObjectsTableSeeder');
        $this->call('CoresTableSeeder');
        $this->call('MissionsTableSeeder');
        $this->call('UsesTableSeeder');
        $this->call('TagsTableSeeder');
        $this->call('NotificationTypesSeeder');
        $this->call('MissionTypesTableSeeder');

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
	}

}
