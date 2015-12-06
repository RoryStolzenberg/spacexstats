<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;
use SpaceXStats\Validators\ValidatableTrait;

class PrelaunchEvent extends Model {

    use ValidatableTrait;

	protected $table = 'prelaunch_events';
	protected $primaryKey = 'prelaunch_event_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Validation
    public $rules = array(
        'mission_id'    => ['integer', 'exists:missions,mission_id'],
        'summary'       => ['varchar:tiny']
    );

    public $messages = array();

	// Relations
	public function mission() {
		return $this->belongsTo('SpaceXStats\Models\Mission');
	}

    // Methods
    public function isScheduledLaunchPrecise() {
        return $this->scheduled_launch_specificity >= LaunchSpecificity::Day;
    }

    // Attribute accessors
    public function getScheduledLaunchDateTimeAttribute() {
        return $this->isScheduledLaunchPrecise() ? $this->scheduled_launch_exact: $this->scheduled_launch_approximate;
    }
}