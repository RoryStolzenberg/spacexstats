<?php
class AstronautFlight extends Eloquent {
    protected $table = 'astronauts_flights_pivot';
    protected $primaryKey = 'astronaut_flight_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];
}