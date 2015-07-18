<?php
class Astronaut extends Eloquent {
    protected $table = 'astronauts';
    protected $primaryKey = 'astronaut_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    public function getDates() {
        return ['date_of_birth'];
    }

    // Relations
    public function spacecraftFlights() {
        return $this->belongsToMany('SpaceraftFlight', 'astronauts_flights_pivot');
    }

    public function spacecraft() {
        return $this->hasManyThrough('Spacecraft', 'SpacecraftFlight');
    }

    //Attribute Accessors
    public function getFullnameAttribute() {
        return $this->attributes['first_name'] . " " . $this->attributes['last_name'];
    }
}