<?php
namespace SpaceXStats\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use SpaceXStats\Library\Enums\Destination;
use SpaceXStats\Library\Enums\MissionStatus;
use SpaceXStats\Models\Mission;
use SpaceXStats\Models\PartFlight;
use SpaceXStats\Models\Payload;
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
		return Cache::remember('stats:launchesPerYear', 60, function() {
			return Mission::select(DB::raw('COUNT(mission_id) AS launches, YEAR(launch_exact) AS year'))->where('status','Complete')->groupBy('year')->get()->toArray();
		});
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
			$seconds = DB::table('spacecraft_flights_pivot')
				->selectRaw('SUM(TIMESTAMPDIFF(SECOND,missions.launch_exact,spacecraft_flights_pivot.end_of_mission)) AS duration')
                ->where('missions.status','Complete')
                ->join('missions','missions.mission_id','=','spacecraft_flights_pivot.mission_id')
                ->first()->duration;

			$stat[0] = floor($seconds / (60 * 60 * 24));
			$seconds -= $stat[0] * 60 * 60 * 24;

			$stat[1] = floor($seconds / (60 * 60));
			$seconds -= $stat[1] * 60 * 60;

			$stat[2] = floor($seconds / 60);
			$seconds -= $stat[2] * 60;

			$stat[3] = $seconds;

			return $stat;
		}

        if ($substatistic === 'Flight Time') {
			return SpacecraftFlight::selectRaw('TIMESTAMPDIFF(SECOND,missions.launch_exact,spacecraft_flights_pivot.end_of_mission) AS duration')
                ->where('missions.status','Complete')
                ->join('missions','missions.mission_id','=','spacecraft_flights_pivot.mission_id')->first();
		}

        if ($substatistic === 'Cargo') {
			$query = SpacecraftFlight::select(DB::raw('SUM(upmass) AS upmass, SUM(downmass) AS downmass'))->whereHas('mission', function($q) {
				$q->whereComplete();
			})->first();

			$stat[0] = $query->upmass;
			$stat[1] = $query->downmass;

			return $stat;
		}

        if ($substatistic === 'Reflights') {
			$query = DB::select(DB::raw("SELECT COALESCE(SUM(reflights), 0) as total_flights FROM (SELECT COUNT(*)-1 as reflights FROM spacecraft JOIN spacecraft_flights_pivot ON spacecraft.spacecraft_id = spacecraft_flights_pivot.spacecraft_id WHERE spacecraft.spacecraft_id=spacecraft_flights_pivot.spacecraft_id GROUP BY spacecraft_flights_pivot.spacecraft_id HAVING reflights > 0) reflights"))[0];
            return $query->total_flights;
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
            $query =  DB::select(DB::raw("SELECT COALESCE(SUM(reflights), 0) as total_flights FROM (SELECT COUNT(*)-1 as reflights FROM parts JOIN part_flights_pivot ON parts.part_id = part_flights_pivot.part_id WHERE parts.part_id=part_flights_pivot.part_id GROUP BY part_flights_pivot.part_id HAVING reflights > 0) reflights"))[0];
            return $query->total_flights;
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
				$q->whereComplete()->whereSpecificVehicle(['Falcon 9 v1.1', 'Falcon 9 v1.2']);
			})->count() * 9;
        }

		if ($substatistic === 'M1D Flight Time') {
			// SELECT SUM(vehicles.firststage_meco) AS flight_time FROM vehicles INNER JOIN missions ON vehicles.mission_id=missions.mission_id WHERE missions.status='Complete' AND vehicles.vehicle='Falcon 9 v1.1'
			$seconds = PartFlight::select(DB::raw('SUM(part_flights_pivot.firststage_meco) AS flight_time'))
				->whereHas('mission', function($q) {
					$q->whereComplete();
				})
				->first()->flight_time;

			$stat[0] = floor($seconds / (60 * 60 * 24));
			$seconds -= $stat[0] * 60 * 60 * 24;

			$stat[1] = floor($seconds / (60 * 60));
			$seconds -= $stat[0] * 60 * 60;

			$stat[2] = floor($seconds / 60);
			$seconds -= $stat[0] * 60;

			$stat[3] = $seconds;

			return $stat;
		}

        if ($substatistic === 'M1D Success Rate') {
			// SELECT SUM(vehicles.firststage_engine_failures) AS engine_failures, ROUND(100 - (SUM(vehicles.firststage_engine_failures) / (COUNT(vehicles.vehicle_id) * 9) * 100)) AS success_rate 
			// FROM vehicles INNER JOIN missions ON vehicles.mission_id=missions.mission_id WHERE missions.status='Complete' AND vehicles.vehicle='Falcon 9 v1.1'
			return PartFlight::select(DB::raw('ROUND(100 - (SUM(part_flights_pivot.firststage_engine_failures) / (COUNT(part_flights_pivot.mission_id) * 9) * 100)) AS success_rate'))
				->whereHas('mission', function($query) {
					$query->whereComplete()->whereSpecificVehicle(['Falcon 9 v1.1', 'Falcon 9 v1.2']);
				})
				->first()->success_rate;
		}
	}

	/**
	 * @param $substatistic
	 * @return string
     */
	public static function capeCanaveral($substatistic) {
		if ($substatistic === 'Launches') {
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
        if ($substatistic === 'Launches') {
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
		if ($substatistic === 'Launches') {
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
		if ($substatistic === 'Launches') {
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
		if ($substatistic === 'Launches') {
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
	 * @param $substatistic
	 * @return int
     */
	public static function dragonRiders($substatistic) {
        if ($substatistic == 'In Space') {
			/* SELECT COUNT(*) FROM astronauts_flights_pivot
JOIN spacecraft_flights_pivot ON spacecraft_flights_pivot.spacecraft_flight_id = astronauts_flights_pivot.spacecraft_flight_id
JOIN missions ON missions.mission_id = spacecraft_flights_pivot.mission_id
WHERE missions.status='IN PROGRESS' */
			return DB::table('astronauts_flights_pivot')
				->join('spacecraft_flights_pivot', 'spacecraft_flights_pivot.spacecraft_flight_id','=','astronauts_flights_pivot.spacecraft_flight_id')
				->join('missions', 'missions.mission_id', '=', 'spacecraft_flights_pivot.mission_id')
				->where('missions.status', MissionStatus::InProgress)
				->count();

		} else if ($substatistic == 'Cumulative') {
			return DB::table('astronauts_flights_pivot')
				->join('spacecraft_flights_pivot', 'spacecraft_flights_pivot.spacecraft_flight_id','=','astronauts_flights_pivot.spacecraft_flight_id')
				->join('missions', 'missions.mission_id', '=', 'spacecraft_flights_pivot.mission_id')
				->where('missions.status', MissionStatus::InProgress)
				->orWhere('missions.status', MissionStatus::Complete)
				->count();
		}
    }

	/**
	 * @return int
     */
	public static function elonMusksBetExpires() {
        return Carbon::create(2026, 1, 1, 0, 0, 0);
    }

	/**
	 * @param $substatistic
	 * @return int
     */
	public static function payloads($substatistic) {
        if ($substatistic == 'Satellites Launched') {
			$payloads = Payload::whereHas('mission', function($q) {
				$q->where('status', MissionStatus::Complete);
			})->get();

            $stat[1] = $payloads->count();
            $stat[0] = $payloads->filter(function($payload) {
                return $payload->primary;
            })->count();

            return $stat;

		} else if ($substatistic == 'Total Mass') {
			return number_format(round(Payload::whereHas('mission', function($q) {
				$q->whereComplete();
			})->sum('mass')));

		} else if ($substatistic == 'Mass to GTO') {
			return number_format(round(Payload::whereHas('mission', function($q) {
				$q->whereComplete()->whereHas('destination', function($q) {
                    $q->whereIn('destination', [Destination::GeostationaryTransferOrbit, Destination::SupersynchronousGTO, Destination::SubsynchronousGTO]);
                });
			})->sum('mass')));

		} else if ($substatistic == 'Heaviest Satellite') {
			return number_format(round(Payload::whereHas('mission', function($q) {
				$q->whereComplete();
			})->max('mass')));
		}
    }

    /**
     * @param $substatistic
     * @return int
     */
	public static function upperStages($substatistic) {
		if ($substatistic == 'In Orbit') {
            return PartFlight::where('upperstage_status', 'In Orbit')->count();
		} else if ($substatistic == 'TLEs') {
			return DB::table('orbital_elements')->count();
		}
    }

	/**
	 * @param $substatistic
	 * @return int
     */
	public static function distance($substatistic) {
		if ($substatistic == 'Earth Orbit') {
			return round(DB::table('orbital_elements')->max('apogee'));
		} else if ($substatistic == 'Solar System') {
			return 0;
		}
    }

	/**
	 * @param $substatistic
	 * @return int
     */
	public static function turnarounds($substatistic) {
        if ($substatistic == 'Quickest') {

            $lowestTurnaround = null;
            $missions = Mission::past()->get()->keyBy('launch_order_id');

            $missions->each(function($mission, $key) use ($missions, &$lowestTurnaround) {
                if ($key == 1) {
                    return null;
                }

                $turnaround = Carbon::parse($mission->launch_exact)->diffInSeconds(Carbon::parse($missions->get($key-1)->launch_exact));
                $lowestTurnaround = $lowestTurnaround == null ? $turnaround : min($lowestTurnaround, $turnaround);
            });

            return $lowestTurnaround;

		} else if ($substatistic == 'Since Last Launch') {
			return Mission::past()->first()->launch_date_time;

		} else if ($substatistic == 'Over Time') {
		}
    }

	/**
	 * Retrieve the number of SpaceX satellites that have been launched to support their internet constellation plans.
	 *
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