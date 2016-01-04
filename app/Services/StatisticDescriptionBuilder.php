<?php
namespace SpaceXStats\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use SpaceXStats\Models\Mission;
use SpaceXStats\Models\PartFlight;
use SpaceXStats\Models\Payload;
use SpaceXStats\Models\SpacecraftFlight;

class StatisticDescriptionBuilder {
    public static function nextLaunch($substatistic, $dynamicString) {
        if ($dynamicString === 'nextLaunchSummary') {
            return Cache::remember('stats:description:nextLaunch:summary', 60, function() {
                return Mission::future(1)->first()->summary;
            });
        }
    }

    public static function launchCount($substatistic, $dynamicString) {
        if ($substatistic === 'Total') {
            if ($dynamicString === 'currentMonth') {
                return Cache::remember('stats:description:launchCount:total:currentMonth', 60, function() {
                    return Carbon::now()->format('F Y');
                });
            }

            if ($dynamicString === 'totalRockets') {
                return Cache::remember('stats:description:launchCount:total:totalRockets', 60, function() {
                    return Mission::whereComplete()->count();
                });
            }
        }

        if ($substatistic === 'Falcon 9') {
            if ($dynamicString === 'launchCount') {
                return Cache::remember('stats:description:launchCount:falcon9:launchCount', 60, function() {
                    return Mission::whereGenericVehicle('Falcon 9')->whereComplete()->count();
                });
            }
        }

        if ($substatistic === 'Falcon Heavy' || $substatistic === 'Falcon 1') {
            if ($dynamicString === 'launchCount') {
                return Cache::remember('stats:description:launchCount:' . $substatistic . ':launchCount', 60, function() use ($substatistic) {
                    return Mission::whereSpecificVehicle($substatistic)->whereComplete()->count();
                });

            }
        }
    }

    public static function dragon($substatistic, $dynamicString) {
        if ($substatistic === 'Missions') {
            if ($dynamicString === 'missionCount') {
                return Cache::remember('stats:description:dragon:missions:missionCount', 60, function() {
                    return SpacecraftFlight::whereHas('mission', function($q) {
                        $q->whereComplete();
                    })->count();
                });
            }
        }

        if ($substatistic === 'ISS Resupplies') {
            if ($dynamicString === 'issResupplyCount') {
                return Cache::remember('stats:description:dragon:issResupplies:issResupplyCount', 60, function() {
                    return SpacecraftFlight::whereNotNull('iss_berth')->whereHas('mission', function($q) {
                        $q->whereComplete();
                    })->count();
                });
            }
        }
    }

    public static function engines($substatistic, $dynamicString) {
        if ($substatistic == 'Flown') {

            $partFlights = Cache::remember('stats:description:engines:flown', 60, function() {
                return PartFlight::whereIn('firststage_engine', ['Merlin 1D', 'Merlin 1D Fullthrust'])->whereHas('mission', function($q) {
                    return $q->whereComplete();
                })->count();
            });

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
                return Cache::remember('stats:description:payloads:satellitesLaunched:satelliteCount', 60, function() {
                    return Payload::whereHas('mission', function($q) {
                        $q->whereComplete();
                    })->count();
                });
            }
        }

        if ($substatistic === 'Heaviest Satellite') {
            if ($dynamicString === 'heaviestSatellite') {
                return Cache::remember('stats:description:payloads:heaviestSatellite:heaviestSatellite', 60, function() {
                    return Payload::orderBy('mass', 'desc')->whereHas('mission', function($q) {
                        $q->whereComplete();
                    })->first()->name;
                });

            }

            if ($dynamicString === 'heaviestOperator') {
                return Cache::remember('stats:description:payloads:heaviestSatellite:heaviestSatellite', 60, function() {
                    return Payload::orderBy('mass', 'desc')->whereHas('mission', function($q) {
                        $q->whereComplete();
                    })->first()->operator;
                });
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