<?php
namespace SpaceXStats\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use SpaceXStats\Models\Mission;
use SpaceXStats\Models\PartFlight;
use SpaceXStats\Models\Spacecraft;
use SpaceXStats\Models\SpacecraftFlight;
use SpaceXStats\Models\Vehicle;

class StatisticResultBuilder {
	/**
	 * @return mixed
     */
	public static function nextLaunch() {
        return Mission::future(1)->first()->toArray();
	}

	/**
	 * Fetch the total launch count for either all missions, or just a particular vehicle type.
	 *
	 * @param string $substatistic	What substatistic are we querying for?
	 * @return int
     */
	public static function launchCount($substatistic) {
		if ($substatistic === 'Total') {
			return Mission::whereComplete()->count();
		}

        if ($substatistic === 'MCT') {
            return 0;
        }

		return Mission::whereComplete()->whereGenericVehicle($substatistic)->count();
	}

	/**
	 * @return mixed
     */
	public static function launchesPerYear() {
		// SELECT COUNT(mission_id) as missions, YEAR(launch_exact) as year FROM missions GROUP BY year
		return Mission::select(DB::raw('*, COUNT(mission_id) AS missions, YEAR(launch_exact) AS year'))->where('status','Complete')->groupBy('year')->get()->toArray();
    }

	/**
	 * @param $substatistic
	 * @return mixed
     */
	public static function dragon($substatistic) {
		if ($substatistic === 'Missions') {
			return SpacecraftFlight::whereHas('mission', function($q) {
				$q->whereComplete();
			})->count();
		}

        if ($substatistic === 'ISS Resupplies') {
			return SpacecraftFlight::whereNotNull('iss_berth')->whereHas('mission', function($q) {
				$q->whereComplete();
            })->count();
		}

        if ($substatistic === 'Total Flight Time') {
			//SELECT SUM(TIMESTAMPDIFF(SECOND,missions.launch_exact,spacecraft.return)) as duration FROM spacecraft INNER JOIN missions ON spacecraft.mission_id=missions.mission_id
			return SpacecraftFlight::select(DB::raw('SUM(TIMESTAMPDIFF(SECOND,missions.launch_exact,spacecraft_flights_pivot.end_of_mission)) AS duration'))
                ->where('missions.status','Complete')
                ->join('missions','missions.mission_id','=','spacecraft_flights_pivot.mission_id')
                ->first();
		}

        if ($substatistic === 'Flight Time (Graph)') {
			return SpacecraftFlight::select('missions.name',DB::raw('TIMESTAMPDIFF(SECOND,missions.launch_exact,spacecraft_flights_pivot.end_of_mission) AS duration'))
                ->where('missions.status','Complete')
                ->join('missions','missions.mission_id','=','spacecraft_flights_pivot.mission_id')->first();
		}

        if ($substatistic === 'Cargo') {
			return SpacecraftFlight::select(DB::raw('SUM(upmass) AS upmass, SUM(downmass) AS downmass'))->whereHas('mission', function($q) {
				$q->whereComplete();
			})->groupBy('upmass')->first();
		}

        if ($substatistic === 'Reflights') {
/*SELECT COALESCE(SUM(reflights), 0) as total_flights FROM (SELECT COUNT(*)-1 as reflights FROM spacecraft
  JOIN spacecraft_flights_pivot ON spacecraft.spacecraft_id = spacecraft_flights_pivot.spacecraft_id
  WHERE spacecraft.spacecraft_id=spacecraft_flights_pivot.spacecraft_id
GROUP BY spacecraft_flights_pivot.spacecraft_id HAVING reflights > 0) reflights*/
        }
	}

	/**
	 * @param $substatistic
	 * @return mixed
     */
	public static function vehicles($substatistic) {
        if ($substatistic == 'Landed') {
            return PartFlight::where('landed', true)->count();
        }

        if ($substatistic == 'Reflown') {
            /* SELECT COALESCE(SUM(reflights), 0) as total_flights FROM (SELECT COUNT(*)-1 as reflights FROM parts
  JOIN part_flights_pivot ON parts.part_id = part_flights_pivot.part_id
  WHERE parts.part_id=part_flights_pivot.part_id
GROUP BY part_flights_pivot.part_id HAVING reflights > 0) reflights */
        }
    }

	/**
	 * Fetch the number of firststage Merlin 1D engines (both normal and fullthrust) flown on operational missions
	 *
	 * @param $substatistic
	 * @return int
     */
	public static function engines($substatistic) {
        if ($substatistic === 'Flown') {
            return PartFlight::whereHas('mission', function($q) {
				$q->whereSpecificVehicle('Falcon 9 v1.1');
			})->count() * 9;
        }

		if ($substatistic === 'Flight Time') {
			// SELECT SUM(vehicles.firststage_meco) AS flight_time FROM vehicles INNER JOIN missions ON vehicles.mission_id=missions.mission_id WHERE missions.status='Complete' AND vehicles.vehicle='Falcon 9 v1.1'
			return Vehicle::select(DB::raw('SUM(vehicles.firststage_meco) AS flight_time'))->where('missions.status','Complete')->join('missions','missions.mission_id','=','vehicles.mission_id')->first();
		
		}

        if ($substatistic === 'Success Rate') {
			// SELECT SUM(vehicles.firststage_engine_failures) AS engine_failures, ROUND(100 - (SUM(vehicles.firststage_engine_failures) / (COUNT(vehicles.vehicle_id) * 9) * 100)) AS success_rate 
			// FROM vehicles INNER JOIN missions ON vehicles.mission_id=missions.mission_id WHERE missions.status='Complete' AND vehicles.vehicle='Falcon 9 v1.1'
			return Vehicle::select(DB::raw('SUM(vehicles.firststage_engine_failures) AS engine_failures, ROUND(100 - (SUM(vehicles.firststage_engine_failures) / (COUNT(vehicles.mission_id) * 9) * 100)) AS success_rate'))
				->where('missions.status','Complete')->join('missions','missions.mission_id','=','vehicles.mission_id')->first();
		}
	}

	/**
	 * @param $substatistic
	 * @return string
     */
	public static function capeCanaveral($substatistic) {
		if ($substatistic === 'Launch Count') {
			return Mission::whereComplete()->whereHas('launchSite', function($q) {
				$q->where('name','SLC-40');
			})->count();

		} else if ($substatistic === 'Last Launch') {
			try {
				$lastLaunch = Mission::lastFromLaunchSite('SLC-40')->firstOrFail();
			} catch (ModelNotFoundException $e) {
				return false;
			}
			return $lastLaunch;

		} else if ($substatistic === 'Next Launch') {
			try {
				$nextLaunch = Mission::nextFromLaunchSite('SLC-40')->firstOrFail();
			} catch (ModelNotFoundException $e) {
				return false;
			}
			return $nextLaunch;			
		}
	}

	/**
	 * @param $substatistic
	 * @return string
     */
	public static function capeKennedy($substatistic) {
        if ($substatistic === 'Launch Count') {
            return Mission::whereComplete()->whereHas('launchSite', function($q) {
                $q->where('name','LC-39A');
            })->count();

        } else if ($substatistic === 'Last Launch') {
            try {
                $lastLaunch = Mission::lastFromLaunchSite('LC-39A')->firstOrFail();
            } catch (ModelNotFoundException $e) {
                return false;
            }
            return $lastLaunch;

        } else if ($substatistic === 'Next Launch') {
            try {
                $nextLaunch = Mission::nextFromLaunchSite('LC-39A')->firstOrFail();
            } catch (ModelNotFoundException $e) {
                return false;
            }
            return $nextLaunch;
        }
    }

	/**
	 * @param $substatistic
	 * @return string
     */
	public static function vandenberg($substatistic) {
		if ($substatistic === 'Launch Count') {
			return Mission::whereComplete()->whereHas('launchSite', function($q) {
				$q->where('name','SLC-4E');
			})->count();

		} else if ($substatistic === 'Last Launch') {
			try {
				$lastLaunch = Mission::lastFromLaunchSite('SLC-4E')->firstOrFail();
			} catch (ModelNotFoundException $e) {
				return false;
			}
			return $lastLaunch;

		} else if ($substatistic === 'Next Launch') {
			try {
				$nextLaunch = Mission::nextFromLaunchSite('SLC-4E')->firstOrFail();
			} catch (ModelNotFoundException $e) {
				return false;
			}
			return $nextLaunch;			
		}
	}

	/**
	 * @param $substatistic
	 * @return string
     */
	public static function bocaChica($substatistic) {
		if ($substatistic === 'Launch Count') {
			return Mission::whereComplete()->whereHas('launchSite', function($q) {
				$q->where('name','Boca Chica');
			})->count();

		} else if ($substatistic === 'Last Launch') {
			try {
				$lastLaunch = Mission::lastFromLaunchSite('Boca Chica')->firstOrFail();
			} catch (ModelNotFoundException $e) {
				return false;
			}
			return $lastLaunch;

		} else if ($substatistic === 'Next Launch') {
			try {
				$nextLaunch = Mission::nextFromLaunchSite('Boca Chica')->firstOrFail();
			} catch (ModelNotFoundException $e) {
				return false;
			}
			return $nextLaunch;			
		}
	}

	/**
	 * @param $substatistic
	 * @return string
     */
	public static function kwajalein($substatistic) {
		if ($substatistic === 'Launch Count') {
			return Mission::whereComplete()->whereHas('launchSite', function($q) {
				$q->where('name','Omelek Island');
			})->count();

		} else if ($substatistic === 'Last Launch') {
			try {
				$lastLaunch = Mission::lastFromLaunchSite('Omelek Island')->firstOrFail();
			} catch (ModelNotFoundException $e) {
				return false;
			}
			return $lastLaunch;

		}
	}

	/**
	 * @param $parameter
	 * @return int
     */
	public static function dragonRiders($parameter) {
        return 0;
    }

	/**
	 * @return int
     */
	public static function elonMusksBetExpires() {
        return 0;
    }

	/**
	 * @param $parameter
	 * @return int
     */
	public static function payloads($parameter) {
        return 0;
    }

	/**
	 * @return int
     */
	public static function upperStagesInOrbit() {
        return 0;
    }

	/**
	 * @param $parameter
	 * @return int
     */
	public static function distance($parameter) {
        return 0;
    }

	/**
	 * @param $parameter
	 * @return int
     */
	public static function turnarounds($parameter) {
        return 0;
    }

	/**
	 * @return int
     */
	public static function internetConstellation() {
        return 0;
    }

	/**
	 * Return the current population of Mars.
	 *
	 * @return int
     */
	public static function marsPopulationCount() {
        return 0; // We can safely return 0 for a few years at least
    }

	/**
	 * Retrieve the number of hours SpaceX employees have worked.
	 *
	 * @return int
     */
	public static function hoursWorked() {
        return 'countless'; // It's true
    }
}
?>