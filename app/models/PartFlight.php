<?php
class PartFlight extends Eloquent {
    protected $table = 'part_flights_pivot';
    protected $primaryKey = 'part_flight_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    public function mission() {
        return $this->belongsTo('Mission');
    }

    public function part() {
        return $this->belongsTo('Spacecraft');
    }
}