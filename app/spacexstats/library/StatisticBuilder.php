<?php
class StatisticBuilder {
	public static function nextLaunch() {
        $var =  Mission::nextMissions(1)->first()->toArray();
	    return $var;
	}

	public static function launchCount($parameter) {
		if ($parameter === 'By Rocket') {
			return Vehicle::select('vehicle', DB::raw('COUNT(vehicle) as vehiclecount'))->with('mission')->whereHas('mission', function($q) {
				$q->where('status','Complete');
			})->groupBy('vehicle')->get();
		}

		return Mission::whereComplete()->with('vehicle')->whereHas('vehicle', function($q) use($parameter) {
			$q->where('vehicle', 'like', ($parameter == 'Falcon 9') ? $parameter . '%' : $parameter);
		})->count();
	}

	public static function launchesPerYear() {
		// SELECT COUNT(mission_id) as missions, YEAR(launch_exact) as year FROM missions GROUP BY year
		return Mission::select(DB::raw('COUNT(mission_id) AS missions, YEAR(launch_exact) AS year'))->where('status','Complete')->groupBy('year')->get();
    }

	public static function dragon($parameter) {
		if ($parameter === 'Missions') {
			return Spacecraft::whereHas('mission', function($q) {
				$q->whereComplete();
			})->count();

		} else if ($parameter === 'ISS Resupplies') {
			return Spacecraft::whereNotNull('iss_berth')->whereHas('mission', function($q) {
				$q->whereComplete();
			})->count();

		} else if ($parameter === 'Total Flight Duration') {
			//SELECT SUM(TIMESTAMPDIFF(SECOND,missions.launch_exact,spacecraft.return)) as duration FROM spacecraft INNER JOIN missions ON spacecraft.mission_id=missions.mission_id
			return Spacecraft::select(DB::raw('SUM(TIMESTAMPDIFF(SECOND,missions.launch_exact,spacecraft.return)) AS duration'))->where('missions.status','Complete')->join('missions','missions.mission_id','=','spacecraft.mission_id')->first();
		
		} else if ($parameter === 'Individual Flight Duration') {
			return Spacecraft::select('missions.name',DB::raw('TIMESTAMPDIFF(SECOND,missions.launch_exact,spacecraft.return) AS duration'))->where('missions.status','Complete')->join('missions','missions.mission_id','=','spacecraft.mission_id')->first();

		} else if ($parameter === 'Cargo') {
			return Spacecraft::select(DB::raw('SUM(upmass) AS upmass, SUM(downmass) AS downmass'))->whereHas('mission', function($q) {
				$q->whereComplete();
			})->first();
		}
	}

	public static function engines($parameter) {
		if ($parameter === 'Flight Time') {
			// SELECT SUM(vehicles.firststage_meco) AS flight_time FROM vehicles INNER JOIN missions ON vehicles.mission_id=missions.mission_id WHERE missions.status='Complete' AND vehicles.vehicle='Falcon 9 v1.1'
			return Vehicle::select(DB::raw('SUM(vehicles.firststage_meco) AS flight_time'))->where('missions.status','Complete')->join('missions','missions.mission_id','=','vehicles.mission_id')->first();
		
		} else if ($parameter === 'Success Rate') {
			// SELECT SUM(vehicles.firststage_engine_failures) AS engine_failures, ROUND(100 - (SUM(vehicles.firststage_engine_failures) / (COUNT(vehicles.vehicle_id) * 9) * 100)) AS success_rate 
			// FROM vehicles INNER JOIN missions ON vehicles.mission_id=missions.mission_id WHERE missions.status='Complete' AND vehicles.vehicle='Falcon 9 v1.1'
			return Vehicle::select(DB::raw('SUM(vehicles.firststage_engine_failures) AS engine_failures, ROUND(100 - (SUM(vehicles.firststage_engine_failures) / (COUNT(vehicles.mission_id) * 9) * 100)) AS success_rate'))
				->where('missions.status','Complete')->join('missions','missions.mission_id','=','vehicles.mission_id')->first();
		}
	}

	public static function launchSiteCount() {
		return LaunchSite::count();
	}

	public static function launchSiteSLC40($parameter) {
		if ($parameter === 'Launch Count') {
			return Mission::whereComplete()->whereHas('launchSite', function($q) {
				$q->where('name','SLC-40');
			})->count();

		} else if ($parameter === 'Last Launch') {
			try {
				$lastLaunch = Mission::lastFromLaunchSite('SLC-40')->firstOrFail();
			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
				return 'false';
			}
			return $lastLaunch;

		} else if ($parameter === 'Next Launch') {
			try {
				$nextLaunch = Mission::nextFromLaunchSite('SLC-40')->firstOrFail();
			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
				return 'false';
			}
			return $nextLaunch;			
		}
	}

	public static function launchSiteSLC4E($parameter) {
		if ($parameter === 'Launch Count') {
			return Mission::whereComplete()->whereHas('launchSite', function($q) {
				$q->where('name','SLC-4E');
			})->count();

		} else if ($parameter === 'Last Launch') {
			try {
				$lastLaunch = Mission::lastFromLaunchSite('SLC-4E')->firstOrFail();
			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
				return 'false';
			}
			return $lastLaunch;

		} else if ($parameter === 'Next Launch') {
			try {
				$nextLaunch = Mission::nextFromLaunchSite('SLC-4E')->firstOrFail();
			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
				return 'false';
			}
			return $nextLaunch;			
		}
	}

	public static function launchSiteLC39A($parameter) {
		if ($parameter === 'Launch Count') {
			return Mission::whereComplete()->whereHas('launchSite', function($q) {
				$q->where('name','LC-39A');
			})->count();

		} else if ($parameter === 'Last Launch') {
			try {
				$lastLaunch = Mission::lastFromLaunchSite('LC-39A')->firstOrFail();
			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
				return 'false';
			}
			return $lastLaunch;

		} else if ($parameter === 'Next Launch') {
			try {
				$nextLaunch = Mission::nextFromLaunchSite('LC-39A')->firstOrFail();
			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
				return 'false';
			}
			return $nextLaunch;			
		}
	}

	public static function launchSiteBocaChica($parameter) {
		if ($parameter === 'Launch Count') {
			return Mission::whereComplete()->whereHas('launchSite', function($q) {
				$q->where('name','Boca Chica');
			})->count();

		} else if ($parameter === 'Last Launch') {
			try {
				$lastLaunch = Mission::lastFromLaunchSite('Boca Chica')->firstOrFail();
			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
				return 'false';
			}
			return $lastLaunch;

		} else if ($parameter === 'Next Launch') {
			try {
				$nextLaunch = Mission::nextFromLaunchSite('Boca Chica')->firstOrFail();
			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
				return 'false';
			}
			return $nextLaunch;			
		}
	}

	public static function launchSiteKwajalein($parameter) {
		if ($parameter === 'Launch Count') {
			return Mission::whereComplete()->whereHas('launchSite', function($q) {
				$q->where('name','Omelek Island');
			})->count();

		} else if ($parameter === 'Last Launch') {
			try {
				$lastLaunch = Mission::lastFromLaunchSite('Omelek Island')->firstOrFail();
			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
				return 'false';
			}
			return $lastLaunch;

		}
	}
}
?>