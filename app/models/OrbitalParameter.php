<?php

class OrbitalParameter extends Eloquent {
    protected $table = 'orbital_parameters';
    protected $primaryKey = 'orbital_parameter_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relationships
    public function mission() {
        return $this->hasOne('Mission');
    }
}