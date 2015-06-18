<?php
class SpacecraftFlight extends Eloquent {
    protected $table = 'spacecraft_flights';
    protected $primaryKey = 'spacecraft_flight_id';
    protected $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    public function mission() {
        return $this->belongsTo('Mission');
    }

    public function spacecraft() {
        return $this->belongsTo('Spacecraft');
    }
}