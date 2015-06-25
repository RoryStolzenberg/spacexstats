<?php
class Location extends Eloquent {
    protected $table = 'locations';
    protected $primaryKey = 'location_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];

    // Relations
    public function uses() {
        return $this->hasMany('Uses');
    }

    public function missions() {
        return $this->hasMany('mission');
    }

    // Attribute Accessors
    public function getFullLocationAttribute() {
        $fullLocation = $this->name;

        if (!is_null($this->location)) {
            $fullLocation .= ', ' . $this->location;
        }

        if (!is_null($this->state)) {
            $fullLocation .= ', ' . $this->state;
        }

        return $fullLocation;
    }
}