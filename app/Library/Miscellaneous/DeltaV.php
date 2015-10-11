<?php
namespace SpaceXStats\Library\Miscellaneous;

class DeltaV {

    const DELTAV_TO_DAY_CONVERSION_RATE     = 1000;
    const SECONDS_PER_DAY                   = 86400;

    /**
     * Calculates the total deltaV value of a particular object.
     *
     * @param   $object Object  The object to calculate the deltaV for.
     * @return  int             The total worth of the object in deltaV.
     */
    public static function calculate(\Object $object) {
        return 1;
    }

    /**
     * For a given amount of deltaV, calculayes the number of seconds mission control it is worth.
     *
     * @param   $deltaV   int   The input value of deltaV.
     * @return  int             The number of seconds of mission control the input deltaV value corresponds to.
     */
    public static function toSeconds($deltaV) {
        // Currently 86.4 seconds per point
        $secondsPerPoint = DeltaV::SECONDS_PER_DAY / DeltaV::DELTAV_TO_DAY_CONVERSION_RATE;

        return (int) round($deltaV * $secondsPerPoint);
    }
}