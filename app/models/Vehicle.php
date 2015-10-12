<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;

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
		return $this->hasMany('SpaceXStats\Models\Mission');
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
