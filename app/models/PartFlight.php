<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;
use SpaceXStats\Validators\ValidatableTrait;

class PartFlight extends Model {

    use ValidatableTrait;

    protected $table = 'part_flights_pivot';
    protected $primaryKey = 'part_flight_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Validation
    public $rules = array(
        'mission_id'                    => ['integer', 'exists:missions,mission_id'],
        'part_id'                       => ['integer', 'exists:parts,part_id'],
        'firststage_landing_legs'       => ['boolean'],
        'firststage_grid_fins'          => ['boolean'],
        'firststage_engine_failures'    => ['min:0', 'integer', 'max:9'],
        'firststage_meco'               => ['min:0', 'integer', 'max:255'],
        'upperstage_seco'               => ['min:0', 'integer', 'max:65535'],
        'landed'                        => ['boolean'],
    );

    public $messages = array();

    // Relations
    public function mission() {
        return $this->belongsTo('SpaceXStats\Models\Mission');
    }

    public function part() {
        return $this->belongsTo('SpaceXStats\Models\Part');
    }

    public function orbitalElements() {
        return $this->hasMany('SpaceXStats\Models\OrbitalElement');
    }
}