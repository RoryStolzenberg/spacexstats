<?php 
class PrelaunchEvent extends Eloquent {

	protected $table = 'prelaunch_events';
	protected $primaryKey = 'prelaunch_event_id';
	public $timestamps = false;

	// Relations
	public function mission() {
		return $this->belongsTo('mission');
	}

}