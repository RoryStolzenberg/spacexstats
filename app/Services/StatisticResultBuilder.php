<?php
namespace SpaceXStats\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use SpaceXStats\Models\Mission;
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

		return Mission::whereComplete()->whereGenericVehicle($parameter)->count();
	}

	/**
	 * @return mixed
     */
	public static function launchesPerYear() {
		// SELECT COUNT(mission_id) as missions, YEAR(launch_exact) as year FROM missions GROUP BY year
		return Mission::select(DB::raw('*, COUNT(mission_id) AS missions, YEAR(launch_exact) AS year'))->where('status','Complete')->groupBy('year')->get()->toArray();
    }

	/**
	 * @param $parameter
	 * @return mixed
     */
	public static function dragon($parameter) {
		if ($parameter === 'Missions') {
			return SpacecraftFlight::whereHas('mission', function($q) {
				$q->whereComplete();
			})->count();
		}

        if ($parameter === 'ISS Resupplies') {
			return SpacecraftFlight::whereNotNull('iss_berth')->whereHas('mission', function($q) {
				$q->whereComplete();
            })->count();
		}

        if ($parameter === 'Total Flight Time') {
			//SELECT SUM(TIMESTAMPDIFF(SECOND,missions.launch_exact,spacecraft.return)) as duration FROM spacecraft INNER JOIN missions ON spacecraft.mission_id=missions.mission_id
			return SpacecraftFlight::select(DB::raw('SUM(TIMESTAMPDIFF(SECOND,missions.launch_exact,spacecraft_flights_pivot.end_of_mission)) AS duration'))
                ->where('missions.status','Complete')
                ->join('missions','missions.mission_id','=','spacecraft_flights_pivot.mission_id')
                ->first();
		}

        if ($parameter === 'Flight Time (Graph)') {
			return SpacecraftFlight::select('missions.name',DB::raw('TIMESTAMPDIFF(SECOND,missions.launch_exact,spacecraft_flights_pivot.end_of_mission) AS duration'))
                ->where('missions.status','Complete')
                ->join('missions','missions.mission_id','=','spacecraft_flights_pivot.mission_id')->first();
		}

        if ($parameter === 'Cargo') {
			return SpacecraftFlight::select(DB::raw('SUM(upmass) AS upmass, SUM(downmass) AS downmass'))->whereHas('mission', function($q) {
				$q->whereComplete();
			})->groupBy('upmass')->first();
		}

        if ($parameter === 'Reflights') {
/*SELECT COALESCE(SUM(reflights), 0) as total_flights FROM (SELECT COUNT(*)-1 as reflights FROM spacecraft
  JOIN spacecraft_flights_pivot ON spacecraft.spacecraft_id = spacecraft_flights_pivot.spacecraft_id
  WHERE spacecraft.spacecraft_id=spacecraft_flights_pivot.spacecraft_id
GROUP BY spacecraft_flights_pivot.spacecraft_id HAVING reflights > 0) reflights*/
        }
	}

	/**
	 * @param $parameter
	 * @return mixed
     */
	public static function vehicles($parameter) {
        if ($parameter == 'Landed') {
            return PartFlight::where('landed', true)->count();
        }

        if ($parameter == 'Reflown') {
            /* SELECT COALESCE(SUM(reflights), 0) as total_flights FROM (SELECT COUNT(*)-1 as reflights FROM parts
  JOIN part_flights_pivot ON parts.part_id = part_flights_pivot.part_id
  WHERE parts.part_id=part_flights_pivot.part_id
GROUP BY part_flights_pivot.part_id HAVING reflights > 0) reflights */
        }
    }

	/**
	 * Fetch the number of firststage Merlin 1D engines (both normal and fullthrust) flown on operational missions
	 *
	 * @param $parameter
	 * @return int
     */
	public static function engines($parameter) {
        if ($parameter === 'Flown') {
            return PartFlight::whereHas('mission', function($q) {
				$q->whereSpecificVehicle('Falcon 9 v1.1');
			})->count() * 9;
        }

		if ($parameter === 'Flight Time') {
			// SELECT SUM(vehicles.firststage_meco) AS flight_time FROM vehicles INNER JOIN missions ON vehicles.mission_id=missions.mission_id WHERE missions.status='Complete' AND vehicles.vehicle='Falcon 9 v1.1'
			return Vehicle::select(DB::raw('SUM(vehicles.firststage_meco) AS flight_time'))->where('missions.status','Complete')->join('missions','missions.mission_id','=','vehicles.mission_id')->first();
		
		}

        if ($parameter === 'Success Rate') {
			// SELECT SUM(vehicles.firststage_engine_failures) AS engine_failures, ROUND(100 - (SUM(vehicles.firststage_engine_failures) / (COUNT(vehicles.vehicle_id) * 9) * 100)) AS success_rate 
			// FROM vehicles INNER JOIN missions ON vehicles.mission_id=missions.mission_id WHERE missions.status='Complete' AND vehicles.vehicle='Falcon 9 v1.1'
			return Vehicle::select(DB::raw('SUM(vehicles.firststage_engine_failures) AS engine_failures, ROUND(100 - (SUM(vehicles.firststage_engine_failures) / (COUNT(vehicles.mission_id) * 9) * 100)) AS success_rate'))
				->where('missions.status','Complete')->join('missions','missions.mission_id','=','vehicles.mission_id')->first();
		}
	}

	/**
	 * @param $parameter
	 * @return string
     */
	public static function capeCanaveral($parameter) {
		if ($parameter === 'Launch Count') {
			return Mission::whereComplete()->whereHas('launchSite', function($q) {
				$q->where('name','SLC-40');
			})->count();

		} else if ($parameter === 'Last Launch') {
			try {
				$lastLaunch = Mission::lastFromLaunchSite('SLC-40')->firstOrFail();
			} catch (ModelNotFoundException $e) {
				return false;
			}
			return $lastLaunch;

		} else if ($parameter === 'Next Launch') {
			try {
				$nextLaunch = Mission::nextFromLaunchSite('SLC-40')->firstOrFail();
			} catch (ModelNotFoundException $e) {
				return false;
			}
			return $nextLaunch;			
		}
	}

	/**
	 * @param $parameter
	 * @return string
     */
	public static function capeKennedy($parameter) {
        if ($parameter === 'Launch Count') {
            return Mission::whereComplete()->whereHas('launchSite', function($q) {
                $q->where('name','LC-39A');
            })->count();

        } else if ($parameter === 'Last Launch') {
            try {
                $lastLaunch = Mission::lastFromLaunchSite('LC-39A')->firstOrFail();
            } catch (ModelNotFoundException $e) {
                return false;
            }
            return $lastLaunch;

        } else if ($parameter === 'Next Launch') {
            try {
                $nextLaunch = Mission::nextFromLaunchSite('LC-39A')->firstOrFail();
            } catch (ModelNotFoundException $e) {
                return false;
            }
            return $nextLaunch;
        }
    }

	/**
	 * @param $parameter
	 * @return string
     */
	public static function vandenberg($parameter) {
		if ($parameter === 'Launch Count') {
			return Mission::whereComplete()->whereHas('launchSite', function($q) {
				$q->where('name','SLC-4E');
			})->count();

		} else if ($parameter === 'Last Launch') {
			try {
				$lastLaunch = Mission::lastFromLaunchSite('SLC-4E')->firstOrFail();
			} catch (ModelNotFoundException $e) {
				return false;
			}
			return $lastLaunch;

		} else if ($parameter === 'Next Launch') {
			try {
				$nextLaunch = Mission::nextFromLaunchSite('SLC-4E')->firstOrFail();
			} catch (ModelNotFoundException $e) {
				return false;
			}
			return $nextLaunch;			
		}
	}

	/**
	 * @param $parameter
	 * @return string
     */
	public static function bocaChica($parameter) {
		if ($parameter === 'Launch Count') {
			return Mission::whereComplete()->whereHas('launchSite', function($q) {
				$q->where('name','Boca Chica');
			})->count();

		} else if ($parameter === 'Last Launch') {
			try {
				$lastLaunch = Mission::lastFromLaunchSite('Boca Chica')->firstOrFail();
			} catch (ModelNotFoundException $e) {
				return false;
			}
			return $lastLaunch;

		} else if ($parameter === 'Next Launch') {
			try {
				$nextLaunch = Mission::nextFromLaunchSite('Boca Chica')->firstOrFail();
			} catch (ModelNotFoundException $e) {
				return false;
			}
			return $nextLaunch;			
		}
	}

	/**
	 * @param $parameter
	 * @return string
     */
	public static function kwajalein($parameter) {
		if ($parameter === 'Launch Count') {
			return Mission::whereComplete()->whereHas('launchSite', function($q) {
				$q->where('name','Omelek Island');
			})->count();

		} else if ($parameter === 'Last Launch') {
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
	 * @return int
     */
	public static function marsPopulationCount() {
        return 0;
    }

	/**
	 * @return int
     */
	public static function hoursWorked() {
        return 0;
    }
}
?>