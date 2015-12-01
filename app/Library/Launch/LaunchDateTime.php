<?php
namespace SpaceXStats\Library\Launch;

use SpaceXStats\Library\Enums\LaunchSpecificity;

class LaunchDateTime {
    protected $launchDateTime, $launchSpecificity;

    public function __construct($launchDateTime, $launchSpecificity) {
        if ($launchDateTime instanceof \DateTime) {
            $this->launchDateTime = $launchDateTime;
        } else {
            $this->launchDateTime = \DateTime::createFromFormat("Y-m-d H:i:s", $launchDateTime);
        }

        $this->launchSpecificity = $launchSpecificity;
    }

    public function getDateTime() {
        return $this->launchDateTime;
    }

    public function getDateTimeString() {
        return $this->launchDateTime->format('Y-m-d H:i:s');
    }

    public function getSpecificity() {
        return $this->launchSpecificity;
    }

    public function isPrecise() {
        return $this->launchSpecificity >= LaunchSpecificity::Day;
    }

    // comparison function for usort()
    public static function compare($firstLaunchDateTime, $secondLaunchDateTime) {
        // first launch will occur before the second launch
        if ($firstLaunchDateTime->getDateTime() < $secondLaunchDateTime->getDateTime()) {
            return -1;
        // first launch will occur after the second launch
        } elseif ($firstLaunchDateTime->getDateTime() > $secondLaunchDateTime->getDateTime()) {
            return 1;
            // both launches are at the same time; resolve via launch specificity!
        } elseif ($firstLaunchDateTime->getDateTime() == $secondLaunchDateTime->getDateTime()) {
            // First launch has a greater specificity than the second launch, occurs first
            if ($firstLaunchDateTime->getSpecificity() < $secondLaunchDateTime->getSpecificity()) {
                return -1;
                // First launch has a lower specificity than the second launch, occurs after
            } elseif ($firstLaunchDateTime->getSpecificity() > $secondLaunchDateTime->getSpecificity()) {
                return 1;
                // Same specificities, same dates. For now, be arbitray, later, use name of launch to resolve
            } elseif ($firstLaunchDateTime->getSpecificity() == $secondLaunchDateTime->getSpecificity()) {
                return 1;
            }
        }
    }
}
