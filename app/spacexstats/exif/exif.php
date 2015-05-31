<?php

namespace SpaceXStats\Exif;

use SpaceXStats\Enums\ExifProperty;

class Exif {
    protected $image, $exif;

    public function __construct($file)
    {
        try {
            $this->exif = exif_read_data($file);
        } catch (ErrorException $e) {
            $this->exif = false;
        }
    }

    public static function create($file) {
        return new Exif($file);
    }

    public function latitude() {
        if ($this->exif && array_key_exists(ExifProperty::GPSLatitude, $this->exif)) {
            return $this->getCoordinate($this->exif[ExifProperty::GPSLatitude], $this->exif['GPSLatitudeRef']);
        } else {
            return null;
        }
    }

    public function longitude() {
        if ($this->exif && array_key_exists(ExifProperty::GPSLongitude, $this->exif)) {
            return $this->getCoordinate($this->exif[ExifProperty::GPSLongitude], $this->exif['GPSLongitudeRef']);
        } else {
            return null;
        }
    }

    public function altitude() {
        if ($this->exif) {
            return null;
        } else {
            return null;
        }
    }

    public function exposure() {
        if ($this->exif) {
           return null;
        } else {
            return null;
        }
    }

    public function aperture() {
        if ($this->exif) {
            return null;
        } else {
            return null;
        }
    }

    public function iso() {
        if ($this->exif && array_key_exists(ExifProperty::ISO, $this->exif)) {
            return $this->exif[ExifProperty::ISO];
        } else {
            return null;
        }
    }

    public function datetime() {
        if ($this->exif) {
            return DateTime::createFromFormat('YYYY-MM-DD HH:MM:SS', $this->exif[ExifProperty::DateTime]);
        } else {
            return null;
        }
    }

    public function cameraMake() {
        if ($this->exif && array_key_exists(ExifProperty::CameraManufacturer, $this->exif)) {
            return $this->exif[ExifProperty::CameraManufacturer];
        } else {
            return null;
        }
    }

    public function cameraModel() {
        if ($this->exif && array_key_exists(ExifProperty::CameraModel, $this->exif)) {
            return $this->exif[ExifProperty::CameraModel];
        } else {
            return null;
        }
    }

    private function hasExif() {
        if (in_array(strtolower($this->image->getClientOriginalExtension()), array('jpg','jpeg'))) {
            return true;
        } else {
            return false;
        }
    }

    // helper function to translate the coordinates from an EXIF image (array format) to decimal degree format
    private function getCoordinate($coordinate, $hemisphere) {
        for ($i = 0; $i < 3; $i++) {
            $part = explode('/', $coordinate[$i]);
            if (count($part) == 1) {
                $coordinate[$i] = $part[0];
            } else if (count($part) == 2) {
                $coordinate[$i] = floatval($part[0])/floatval($part[1]);
            } else {
                $coordinate[$i] = 0;
            }
        }
        list($degrees, $minutes, $seconds) = $coordinate;
        $sign = ($hemisphere == 'W' || $hemisphere == 'S') ? -1 : 1;
        return $sign * ($degrees + $minutes/60 + $seconds/3600);
    }

    /**
     * Returns the greatest common divisor of two integers using the Euclidean algorithm.
     *
     * @param $a
     * @param $b
     *
     * @return int
     */
    private function euclideanGreatestCommonDivisor($a, $b) {
        $large = $a > $b ? $a: $b;
        $small = $a > $b ? $b: $a;
        $remainder = $large % $small;
        return 0 == $remainder ? $small : $this->euclideanGreatestCommonDivisor( $small, $remainder );
    }
}