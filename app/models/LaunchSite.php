<?php

class LaunchSite extends Eloquent {

	protected $table = 'launch_sites';
	protected $primaryKey = 'launch_site_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

	// Relations
	public function missions() {
		return $this->hasMany('mission');
	}

	// Attribute Accessors
	public function getFullLocationAttribute() {
		return $this->name . ', ' . $this->location . ', ' . $this->state;
	}
}