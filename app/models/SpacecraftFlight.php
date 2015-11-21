<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;
use SpaceXStats\Validators\ValidatableTrait;

class SpacecraftFlight extends Model {

    use ValidatableTrait;

    protected $table = 'spacecraft_flights_pivot';
    protected $primaryKey = 'spacecraft_flight_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Validation
    public $rules = array(
        'mission_id'    => ['integer', 'exists:missions,mission_id'],
        'spacecraft_id' => ['integer', 'exists:spacecraft,spacecraft_id'],
        'flight_name'   => ['required', 'varchar:tiny'],
        'upmass'        => ['numeric'],
        'downmass'      => ['numeric']
    );

    public $messages = array();

    // Relations
    public function mission() {
        return $this->belongsTo('SpaceXStats\Models\Mission');
    }

    public function spacecraft() {
        return $this->belongsTo('SpaceXStats\Models\Spacecraft');
    }

    public function astronauts() {
        return $this->belongsToMany('SpaceXStats\Models\Astronaut', 'astronauts_flights_pivot');
    }

    public function astronautFlights() {
        return $this->hasMany('SpaceXStats\Models\AstronautFlight');
    }

    // Methods
    public function didVisitISS() {
        return !is_null($this->iss_berth);
    }

    // Attribute Accessors
    public function getFlightNumberForSpacecraftAttribute() {
        $self = $this;
        return SpacecraftFlight::whereHas('spacecraft', function($q) use ($self) {
            $q->where('spacecraft_id', $self->spacecraft->id);
        })->whereHas('mission', function($q) use ($self) {
            $q->before($self->mission->launch_order_id);
        })->count() + 1;
    }
}