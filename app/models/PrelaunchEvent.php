<?php 
class PrelaunchEvent extends Eloquent {

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
		return $this->belongsTo('mission');
	}
}