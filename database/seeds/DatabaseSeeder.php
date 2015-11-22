<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

		$this->call('RolesTableSeeder');
        $this->call('DestinationsTableSeeder');
        $this->call('LocationsTableSeeder');
        $this->call('MissionTypesTableSeeder');
        $this->call('VehiclesTableSeeder');
        $this->call('UsersTableSeeder');
        $this->call('ProfilesTableSeeder');
        $this->call('StatisticsTableSeeder');
        $this->call('PartsTableSeeder');
        $this->call('MissionsTableSeeder');
        $this->call('PartFlightsTableSeeder');
        $this->call('TagsTableSeeder');
        $this->call('NotificationTypesTableSeeder');
        $this->call('NotificationsTableSeeder');
        $this->call('AstronautsTableSeeder');
        $this->call('PublishersTableSeeder');
        $this->call('SpacecraftTableSeeder');
        $this->call('SpacecraftFlightsTableSeeder');
        $this->call('PayloadsTableSeeder');
        $this->call('TelemetryTableSeeder');

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
	}

}
