<?php

class Vehicle extends Eloquent {
	protected $table = 'vehicles';
	protected $primaryKey = 'vehicle_id';
	public $timestamps = false;

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
