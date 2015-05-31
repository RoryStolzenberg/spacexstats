<?php

class LaunchDateTime {
    protected $launchDateTime, $launchSpecificity;

    public function __construct($launchDateTime, $launchSpecificity) {
        $this->launchDateTime = $launchDateTime;
        $this->launchSpecificity = $launchSpecificity;
    }

    public function getDateTime() {
        return $this->launchDateTime;
    }

    public function getSpecificity() {
        return $this->launchSpecificity;
    }
}
