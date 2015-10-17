<?php

namespace SpaceXStats\Library\Exif;

use SpaceXStats\Library\Enums\ExifProperty;

class Exif {
    protected $image, $exif;

    public function __construct($file)
    {
        try {
            $this->exif = exif_read_data($file);
        } catch (\ErrorException $e) {
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
        }
        return null;
    }

    public function altitude() {
        return array_get($this->exif, ExifProperty::GPSAltitude, null);
    }

    public function exposure() {
        return array_get($this->exif, ExifProperty::Exposure, null);
    }

    public function aperture() {
        return array_get($this->exif, ExifProperty::Aperture, null);
    }

    public function iso() {
        return array_get($this->exif, ExifProperty::ISO, null);
    }

    public function datetime() {
        if ($this->exif && array_key_exists(ExifProperty::DateTime, $this->exif)) {
            $some = $this->exif[ExifProperty::DateTime];
            return \DateTime::createFromFormat('Y:m:d H:i:s', $this->exif[ExifProperty::DateTime])->format('Y-m-d H:i:s');
        }
        return null;
    }

    public function cameraMake() {
        return array_get($this->exif, ExifProperty::CameraManufacturer, null);
    }

    public function cameraModel() {
        return array_get($this->exif, ExifProperty::CameraModel, null);
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