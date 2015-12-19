<?php
namespace SpaceXStats\Services;

use SpaceXStats\Models\Mission;
use SpaceXStats\Models\PartFlight;
use SpaceXStats\Models\Payload;
use SpaceXStats\Models\SpacecraftFlight;

class StatisticDescriptionBuilder {
    public static function nextLaunch($substatistic, $dynamicString) {
        if ($dynamicString === 'nextLaunchSummary') {
            return Mission::future(1)->first()->summary;
        }
    }

    public static function launchCount($substatistic, $dynamicString) {
        if ($substatistic === 'Total') {
            if ($dynamicString === 'currentMonth') {
                return Carbon::now()->format('F Y');
            }

            if ($dynamicString === 'totalRockets') {
                return Mission::whereComplete()->count();
            }
        }

        if ($substatistic === 'Falcon 9') {
            if ($dynamicString === 'n') {
                return Mission::whereGenericVehicle('Falcon 9')->whereComplete()->count();
            }
        }

        if ($substatistic === 'Falcon Heavy' || $substatistic === 'Falcon 1') {
            if ($dynamicString === 'n') {
                return Mission::whereSpecificVehicle($substatistic)->whereComplete()->count();
            }
        }
    }

    public static function dragon($substatistic, $dynamicString) {
        if ($substatistic === 'Missions') {
            if ($dynamicString === 'n') {
                return SpacecraftFlight::whereHas('mission', function($q) {
                    $q->whereComplete();
                })->count();
            }
        }

        if ($substatistic === 'ISS Resupplies') {
            if ($dynamicString === 'n') {
                return SpacecraftFlight::whereNotNull('iss_berth')->whereHas('mission', function($q) {
                    $q->whereComplete();
                })->count();
            }
        }
    }

    public static function engines($substatistic, $dynamicString) {
        if ($substatistic == 'Flown') {

            $partFlights = PartFlight::whereIn('firststage_engine', ['Merlin 1D', 'Merlin 1D Fullthrust'])->whereHas('mission', function($q) {
                return $q->whereComplete();
            })->count();

            if ($dynamicString === 'engineCount') {
                return $partFlights * 9;
            }

            if ($dynamicString === 'flightCount') {
                return $partFlights;
            }
        }
    }

    public static function payloads($substatistic, $dynamicString) {
        if ($substatistic === 'Satellites Launched') {
            if ($dynamicString === 'satelliteCount') {
                return Payload::whereHas('mission', function($q) {
                    $q->whereComplete();
                })->count();
            }
        }

        if ($substatistic === 'Heaviest Satellite') {
            if ($dynamicString === 'heaviestSatellite') {
                return Payload::orderBy('mass', 'desc')->whereHas('mission', function($q) {
                    $q->whereComplete();
                })->first()->name;
            }

            if ($dynamicString === 'heaviestOperator') {
                return Payload::orderBy('mass', 'desc')->whereHas('mission', function($q) {
                    $q->whereComplete();
                })->first()->contractor;
            }
        }
    }

    public static function distance($substatistic) {
        return 0;
    }

    public static function turnarounds($substatistic) {
        return 0;
    }
}