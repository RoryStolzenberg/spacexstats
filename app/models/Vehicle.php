<?php

class Vehicle extends Eloquent {
	protected $table = 'vehicles';
	protected $primaryKey = 'vehicle_id';
    protected $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

	// Relations
	public function missions() {
		return $this->hasMany('Mission');
	}

	// Attribute Accessors
	public function getSpecificVehicleAttribute() {
		return $this->vehicle;
	}

	public function getGenericVehicleAttribute() {
		if (strpos($this->vehicle,'Falcon 9') !== false) {
			return 'Falcon 9';
		} else {
			return $this->vehicle;
		}
	}
}
