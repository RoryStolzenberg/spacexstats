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
        $now = Carbon::now();

        // Fetch all the missions we want to query orbital elements for.
        $missions = Mission::with(['orbitalElements', 'partFlights'])
            ->whereComplete()->where('outcome', MissionOutcome::Success)
            ->whereHas('upperStage', function($q) {
                $q->whereNotNull('upperstage_norad_id');
            })->get();

        // Login to SpaceTrack
        $ephemeris = new Ephemeris(Config::get('services.spacetrack.identity'), Config::get('services.spacetrack.password'));

        $allOrbitalElements = collect();

        foreach ($missions as $mission) {

            // Create the identifier
            $identifier = new NoradID($mission->upperStage->upperstage_norad_id);

            if ($mission->orbitalElements->count() == 0) {
                // Attempt to fetch all TLE's as we presume the mission was just recently completed or added and we cannot
                // place a reasonable boundary on when to start fetching TLE's.
                $tles = collect($ephemeris->tles()->latest()->satellite($identifier)->fetch());

                $this->info('Got ' . $tles->count() . ' tles for ' . $identifier->identify());

            } else {
                // Only fetch TLE's from the past 30 days because we know this query runs every day (why not
                // fetch from the past day? SpaceTrack clarifies: "Note that in rare cases space-track may
                // receive a TLE with an earlier EPOCH than the most recently uploaded TLE.")
                $tles = $ephemeris->tles()->satellite($identifier)->lastMonth()->fetch();

                $tles = collect($tles)->filter(function($tle) use ($mission) {
                    return $this->isTLENew($tle, $mission->orbitalElements);
                });
            }

            // Turn the TLE's into OrbitalElements
            $missionOrbitalElements = $tles->map(function($tle) use ($mission, $now) {
                $orbitalElement = new OrbitalElement();
                $orbitalElement->part_flight_id = $mission->upperStage->part_flight_id;
                $orbitalElement->object_name = $tle->OBJECT_NAME;
                $orbitalElement->object_type = $tle->OBJECT_TYPE;
                $orbitalElement->classification_type = $tle->CLASSIFICATION_TYPE;
                $orbitalElement->epoch = $tle->EPOCH;
                $orbitalElement->mean_motion = $tle->MEAN_MOTION;
                $orbitalElement->eccentricity = $tle->ECCENTRICITY;
                $orbitalElement->inclination = $tle->INCLINATION;
                $orbitalElement->ra_of_asc_node = $tle->RA_OF_ASC_NODE;
                $orbitalElement->arg_of_pericenter = $tle->ARG_OF_PERICENTER;
                $orbitalElement->mean_anomaly = $tle->MEAN_ANOMALY;
                $orbitalElement->ephemeris_type = $tle->EPHEMERIS_TYPE;
                $orbitalElement->element_set_no = $tle->ELEMENT_SET_NO;
                $orbitalElement->rev_at_epoch = $tle->REV_AT_EPOCH;
                $orbitalElement->bstar = $tle->BSTAR;
                $orbitalElement->mean_motion_dot = $tle->MEAN_MOTION_DOT;
                $orbitalElement->mean_motion_ddot = $tle->MEAN_MOTION_DDOT;
                $orbitalElement->file = $tle->FILE;
                $orbitalElement->tle_line0 = $tle->TLE_LINE0;
                $orbitalElement->tle_line1 = $tle->TLE_LINE1;
                $orbitalElement->tle_line2 = $tle->TLE_LINE2;
                $orbitalElement->semimajor_axis = $tle->SEMIMAJOR_AXIS;
                $orbitalElement->period = $tle->PERIOD;
                $orbitalElement->apogee = $tle->APOGEE;
                $orbitalElement->perigee = $tle->PERIGEE;
                $orbitalElement->created_at = $orbitalElement->updated_at = $now;

                return $orbitalElement;
            });

            $missionOrbitalElements->each(function($orbitalElement) {
                OrbitalElement::create($orbitalElement->toArray());
            });
        }
    }

    public function isTLENew($tle, $orbitalElements) {
        $orbitalElementEpoches = $orbitalElements->map(function($orbitalElement) {
            return $orbitalElement->epoch;
        })->toArray();

        return !in_array($tle->epoch, $orbitalElementEpoches);
    }
}
