<?php

class Part extends Eloquent {
    protected $table = 'parts';
    protected $primaryKey = 'part_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    public function missions() {
        return $this->belongsToMany('Mission', 'part_flights_pivot');
    }

    public function partFlights() {
        return $this->hasMany('PartFlights');
    }
}