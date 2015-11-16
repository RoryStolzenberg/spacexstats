<?php
namespace SpaceXStats\Library\Miscellaneous;

use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Models\Object;

class DeltaV {

    const DELTAV_TO_DAY_CONVERSION_RATE     = 1000;
    const SECONDS_PER_DAY                   = 86400;

    protected $object, $score;

    protected $baseTypeScores = [
        MissionControlType::Image       => 50,
        MissionControlType::GIF         => 50,
        MissionControlType::Audio       => 0,
        MissionControlType::Video       => 0,
        MissionControlType::Document    => 50,
        MissionControlType::Tweet       => 10,
        MissionControlType::Article     => 25,
        MissionControlType::Comment     => 1,
        MissionControlType::Webpage     => 50,
        MissionControlType::Text        => 0
    ];

    protected $specialTypeMultiplier = [

    ];

    protected $resourceQualityScore = [

    ];

    protected $metadataScore = [

    ];

    protected $dateAccuracyScore = [

    ];

    protected $dataSaverMultiplier = [
        'hasExternalUrl' => 2
    ];

    /**
     * Calculates the total deltaV value of a particular object
     *
     * @param   $object   SpaceXStats\Models\Object   The object to calculate the deltaV for.
     * @return  int                                     The total worth of the object in deltaV.
     */
    public function calculate(Object $object) {
        $this->object = $object;
    }

    private function baseScoreRegime() {

    }

    /**
     * For a given amount of deltaV, calculayes the number of seconds mission control it is worth.
     *
     * @param   $deltaV   int   The input value of deltaV.
     * @return  int             The number of seconds of mission control the input deltaV value corresponds to.
     */
    public function toSeconds($deltaV) {
        // Currently 86.4 seconds per point
        $secondsPerPoint = DeltaV::SECONDS_PER_DAY / DeltaV::DELTAV_TO_DAY_CONVERSION_RATE;

        return (int) round($deltaV * $secondsPerPoint);
    }
}