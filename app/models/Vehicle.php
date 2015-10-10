<?php
namespace App\Models;

class Vehicle extends Model {
	protected $table = 'vehicles';
	protected $primaryKey = 'vehicle_id';
    public $timestamps = false;

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
