<?php
namespace SpaceXStats\Library\Miscellaneous;

use SpaceXStats\Models\Mission;

class StatisticDescriptionBuilder {
    public static function nextLaunch($substatistic, $dynamicString) {
        if ($dynamicString === 'nextLaunchSummary') {
            return Mission::future(1)->first()->summary;
        }
    }

    public static function launchCount($substatistic, $dynamicString) {
        if ($substatistic === 'Falcon 9') {
            if ($dynamicString === 'n') {
                return Mission::whereHas('Vehicle', function($q) {
                    $q->whereIn('vehicle', array('Falcon 9 v1.0', 'Falcon 9 v1.1', 'Falcon 9 v1.2'));
                })->whereComplete()->count();
            }
        } elseif ($substatistic === 'Falcon Heavy') {
            if ($dynamicString === 'n') {
                return Mission::whereSpecificVehicle('Falcon Heavy')->whereComplete()->count();
            }
        }
    }
}