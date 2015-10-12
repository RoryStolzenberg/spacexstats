<?php
namespace SpaceXStats\Models;
use Illuminate\Database\Eloquent\Model;
use SpaceXStats\Validators\ValidatableTrait;

class Part extends Model {

    use ValidatableTrait;

    protected $table = 'parts';
    protected $primaryKey = 'part_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Validation
    public $rules = array(
        'name'          => ['required', 'varchar:tiny'],
        'type'          => ['required']
    );

    public $messages = array();

    // Relations
    public function missions() {
        return $this->belongsToMany('SpaceXStats\Models\Mission', 'part_flights_pivot');
    }

    public function partFlights() {
        return $this->hasMany('SpaceXStats\Models\PartFlight');
    }
}