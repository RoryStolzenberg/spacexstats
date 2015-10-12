<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;
use SpaceXStats\Validators\ValidatableTrait;

class Astronaut extends Model {

    use ValidatableTrait;

    protected $table = 'astronauts';
    protected $primaryKey = 'astronaut_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = ['fullName'];
    protected $fillable = [];
    protected $guarded = [];

    public function getDates() {
        return ['date_of_birth'];
    }

    // Validation
    public $rules = array(
        'first_name'    => ['required', 'varchar:tiny'],
        'last_name'     => ['required', 'varchar:tiny'],
        'nationality'   => ['required', 'varchar:tiny'],
        'contracted_by' => ['required', 'varchar:tiny'],
    );

    public $messages = array();

    // Relations
    public function astronautFlights() {
        return $this->belongsToMany('SpaceXStats\Models\AstronautFlight', 'astronauts_flights_pivot');
    }

    public function spacecraft() {
        return $this->hasManyThrough('SpaceXStats\Models\Spacecraft', 'SpaceXStats\Models\AstronautFlight');
    }

    //Attribute Accessors
    public function getFullnameAttribute() {
        return $this->attributes['first_name'] . " " . $this->attributes['last_name'];
    }
}