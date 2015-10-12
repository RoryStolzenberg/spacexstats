<?php
namespace SpaceXStats\Models;
use Illuminate\Database\Eloquent\Model;
use SpaceXStats\Validators\ValidatableTrait;

class AstronautFlight extends Model {

    use ValidatableTrait;

    protected $table = 'astronauts_flights_pivot';
    protected $primaryKey = 'astronaut_flight_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Validation
    public $rules = array(
        'astronaut_id'          => ['required', 'integer', 'exists:astronauts,astronaut_id'],
        'spacecraft_flight_id'  => ['required', 'integer', 'exists:spacecraft_flights,spacecraft_flight_id'],
    );

    public $messages = array();

    public function astronaut() {
        return $this->belongsTo('SpaceXStats\Models\Astronaut');
    }

    public function spacecraftFlight() {
        return $this->belongsTo('SpaceXStats\Models\SpacecraftFlight');
    }
}