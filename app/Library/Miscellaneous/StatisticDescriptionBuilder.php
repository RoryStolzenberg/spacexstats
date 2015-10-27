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
        if ($substatistic === 'Total') {
            if ($dynamicString === 'n') {
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

    public static function launchesPerYear() {
        return 0;
    }

    public static function dragon($parameter) {
        return 0;
    }

    public static function vehicles($parameter) {
        return 0;
    }

    public static function engines($parameter) {
        return 0;
    }

    public static function capeCanaveral($parameter) {
        return 0;
    }

    public static function capeKennedy($parameter) {
        return 0;
    }

    public static function vandenberg($parameter) {
        return 0;
    }

    public static function bocaChica($parameter) {
        return 0;
    }

    public static function kwajalein($parameter) {
        return 0;
    }

    public static function astronauts($substatistic) {
        return 0;
    }

    public static function elonMusksBetExpires($substatistic) {
        return 0;
    }

    public static function payloads($substatistic) {
        return 0;
    }

    public static function upperStagesInOrbit($substatistic) {
        return 0;
    }

    public static function distance($substatistic) {
        return 0;
    }

    public static function turnarounds($substatistic) {
        return 0;
    }

    public static function internetConstellation($substatistic) {
        return 0;
    }

    public static function marsPopulationCount($substatistic) {
        return 0;
    }

    public static function hoursWorked($substatistic) {
        return 0;
    }
}