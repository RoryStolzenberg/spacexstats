<?php

namespace SpaceXStats\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use LukeNZ\Ephemeris\Ephemeris;
use LukeNZ\Ephemeris\SatelliteIdentifiers\NoradID;
use SpaceXStats\Library\Enums\MissionOutcome;
use SpaceXStats\Models\Mission;
use SpaceXStats\Models\OrbitalElement;

class SpaceTrackDataFetchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spacetrack:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch TLE and satellite data from SpaceTrack';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Mass assignment in Laravel doesn't set timestamps, manually create them instead
        $timestamps['created_at'] = $timestamps['updated_at'] = Carbon::now();

        // Fetch all the missions we want to query orbital elements for.
        $missions = Mission::with(['orbitalElements', 'partFlights'])
            ->whereComplete()->where('outcome', MissionOutcome::Success)
            ->whereHas('partFlights', function($q) {
                $q->whereNotNull('upperstage_norad_id');
            })->get();

        // Login to SpaceTrack
        $ephemeris = new Ephemeris(Config::get('services.spacetrack.identity'), Config::get('services.spacetrack.password'));

        $allOrbitalElements = [];

        foreach ($missions as $mission) {

            // Create the identifier
            $identifier = new NoradID($mission->norad_id);

            if ($mission->orbitalElements->count() == 0) {
                // Attempt to fetch all TLE's as we presume the mission was just recently completed or added and we cannot
                // place a reasonable boundary on when to start fetching TLE's.
                $tles = collect($ephemeris->tles()->satellite($identifier)->all());

            } else {
                // Only fetch TLE's from the past 30 days because we know this query runs every day (why not
                // fetch from the past day? SpaceTrack clarifies: "Note that in rare cases space-track may
                // receive a TLE with an earlier EPOCH than the most recently uploaded TLE."
                $tles = $ephemeris->tles()->satellite($identifier)->lastMonth()->fetch();

                $tles = collect($tles)->filter(function($tle) use ($mission) {
                    return $this->isTLENew($tle, $mission->orbitalElements);
                });
            }

            // Turn the TLE's into OrbitalElements
            $missionOrbitalElements = $tles->map(function($tle) {
                $orbitalElement = new OrbitalElement();
                //$orbitalElement->part_flight_id = $mission->partFlights->
                $orbitalElement->object_name = $tle->object_name;
                $orbitalElement->object_type = $tle->object_type;
                $orbitalElement->classification_type = $tle->classification_type;
                $orbitalElement->epoch = $tle->epoch;
                $orbitalElement->mean_motion = $tle->mean_motion;
                $orbitalElement->eccentricity = $tle->eccentricity;
                $orbitalElement->inclination = $tle->inclination;
                $orbitalElement->ra_of_asc_node = $tle->ra_of_asc_node;
                $orbitalElement->arg_of_pericenter = $tle->arg_of_pericenter;
                $orbitalElement->mean_anomaly = $tle->mean_anomaly;
                $orbitalElement->ephemeris_type = $tle->ephemeris_type;
                $orbitalElement->element_set_no = $tle->element_set_no;
                $orbitalElement->rev_at_epoch = $tle->rev_at_epoch;
                $orbitalElement->bstar = $tle->bstar;
                $orbitalElement->mean_motion_dot = $tle->mean_motion_dot;
                $orbitalElement->mean_motion_ddot = $tle->mean_motion_ddot;
                $orbitalElement->file = $tle->file;
                $orbitalElement->tle_line0 = $tle->tle_line0;
                $orbitalElement->tle_line1 = $tle->tle_line1;
                $orbitalElement->tle_line2 = $tle->tle_line2;
                $orbitalElement->semimajor_axis = $tle->semimajor_axis;
                $orbitalElement->period = $tle->period;
                $orbitalElement->apogee = $tle->apogee;
                $orbitalElement->perigee = $tle->perigee;
                return $orbitalElement;
            });

            $allOrbitalElements = array_merge($allOrbitalElements, $missionOrbitalElements);
        }

        OrbitalElement::insert($allOrbitalElements);
    }

    public function isTLENew($tle, $orbitalElements) {
        $orbitalElementEpoches = $orbitalElements->map(function($orbitalElement) {
            return $orbitalElement->epoch;
        })->toArray();

        return !in_array($tle->epoch, $orbitalElementEpoches);
    }
}
