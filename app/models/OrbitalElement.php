<?php
namespace SpaceXStats\Models;
use Illuminate\Database\Eloquent\Model;

class OrbitalElement extends Model {
    protected $table = 'orbital_elements';
    protected $primaryKey = 'orbital_element_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    public $dates = ['epoch'];

    // Relationships
   public function partFlight() {
        return $this->belongsTo('SpaceXStats\Models\PartFlight');
    }
}