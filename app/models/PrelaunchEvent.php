<?php 
class PrelaunchEvent extends Eloquent {

	protected $table = 'prelaunch_events';
	protected $primaryKey = 'prelaunch_event_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

	// Relations
	public function mission() {
		return $this->belongsTo('mission');
	}
}