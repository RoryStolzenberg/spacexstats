<?php
class SpacecraftFlight extends Eloquent {
    protected $table = 'spacecraft_flights';
    protected $primaryKey = 'spacecraft_flight_id';
    public $timestamps = false;

    public function mission() {
        return $this->belongsTo('Mission');
    }

    public function spacecraft() {
        return $this->belongsTo('Spacecraft');
    }
}