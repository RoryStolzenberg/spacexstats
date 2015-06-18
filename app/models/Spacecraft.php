<?php

class Spacecraft extends Eloquent {

	protected $table = 'spacecraft';
	protected $primaryKey = 'spacecraft_id';
    protected $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

	// Relations
    public function spacecraftFlights() {
        return $this->hasOneOrMany('SpacecraftFlights');
    }

	public function missions() {
		return $this->hasManyThrough('Mission', 'SpacecraftFlights');
	}

	// Attribute Accessors
}
