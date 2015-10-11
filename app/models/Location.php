<?php
namespace SpaceXStats\Models;
class Location extends Model {
    protected $table = 'locations';
    protected $primaryKey = 'location_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = ['fullLocation'];
    protected $fillable = [];

    // Relations
    public function uses() {
        return $this->hasMany('Uses', 'landing_site_id');
    }

    public function missions() {
        return $this->hasMany('mission', 'launch_site_id');
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