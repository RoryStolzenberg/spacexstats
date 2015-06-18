<?php

class LandingSite extends Eloquent {
    protected $table = 'landing_sites';
    protected $primaryKey = 'landing_site_id';
    protected $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relations
    public function uses() {
        return $this->hasMany('Uses');
    }

    // Attribute Accessors
    public function getFullLocationAttribute() {
        $fullLocation = $this->name;

        if (!is_null($this->location)) {
            $fullLocation .= ', ' . $this->location;
        }

        if (!is_null($this->state)) {
            $fullLocation .= ', ' . $this->state;
        }

        return $fullLocation;
    }
}