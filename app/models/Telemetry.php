<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;
use SpaceXStats\Validators\ValidatableTrait;

class Telemetry extends Model {

    use ValidatableTrait;

    protected $table = 'telemetry';
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
        return $this->belongsTo('SpaceXStats\Models\Mission');
    }

    // functions
    public function hasPositionalData() {
        return ($this->attributes['altitude'] != null || $this->attributes['downrange'] != null || $this->attributes['velocity'] != null);
    }

    // Attribute accessors
    public function getFormattedTimestampAttribute() {
        $totalSeconds = $this->attributes['timestamp'];

        $minutes = floor($totalSeconds / 60);
        $seconds = sprintf('%02d', $totalSeconds - ($minutes * 60));
        return "{$minutes}:{$seconds}s";
    }
}