<?php

class LaunchSite extends Eloquent {

	protected $table = 'launch_sites';
	protected $primaryKey = 'launch_site_id';
	public $timestamps = false;

	// Relations
	public function missions() {
		return $this->hasMany('mission');
	}

	// Attribute Accessors
	public function getFullLocationAttribute() {
		return $this->name . ', ' . $this->location . ', ' . $this->state;
	}
}