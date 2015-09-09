<?php
class Astronaut extends Eloquent {

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
    public function spacecraftFlights() {
        return $this->belongsToMany('SpaceraftFlight', 'astronauts_flights_pivot');
    }

    public function spacecraft() {
        return $this->hasManyThrough('Spacecraft', 'SpacecraftFlight');
    }

    //Attribute Accessors
    public function getFullnameAttribute() {
        return $this->attributes['first_name'] . " " . $this->attributes['last_name'];
    }
}