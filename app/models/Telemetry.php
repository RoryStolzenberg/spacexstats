<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;
use SpaceXStats\Validators\ValidatableTrait;

class Telemetry extends Model {

    use ValidatableTrait;

    protected $table = 'telemetries';
    protected $primaryKey = 'telemetry_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Validation
    public $rules = array(
        'mission_id'    => ['integer', 'exists:missions,mission_id'],
        'timestamp'     => ['integer'],
        'readout'       => ['varchar:small'],
        'altitude'      => ['integer'],
        'velocity'      => ['integer'],
        'downrange'     => ['integer']
    );

    public $messages = array();

    // Relations
    public function mission() {
        return $this->belongsTo('Mission');
    }
}