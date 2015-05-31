<?php

class Favorite extends Eloquent {

	protected $table = 'favorites';
	protected $primaryKey = 'favorite_id';
	public $timestamps = false;

	// Relations
	public function users() {
		return $this->belongsTo('user');
	}

	public function object() {
		return $this->belongsTo('object');
	}
}